<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\SubmissionManagement\Controllers\Events;


use App\Http\Controllers\Controller;

use App\Models\BaseModel\Submission;
use App\Models\BaseModel\SubmissionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:EventManagement-Create'])->only(['store','newevent']);
        $this->middleware(['role:EventManagement-Save'])->only(['update','index','activate']);
    }

    public function index($id) {
        $events = SubmissionEvent::findOrFail($id);
        $data = [
            'action'        => route('admin.event.update', $id),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'eventmodal',
            'title'         => 'Create New Event',
            'parentlist'    => SubmissionEvent::parentlist(),
            'ev'        => $events
        ];
        return view("SubmissionManagement::events.medit", $data);
    }


    public function newevent() {
        $data = [
            'action'        => route('admin.event.store'),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'eventmodal',
            'title'         => 'Create New Event',
            'parentlist'    => SubmissionEvent::parentlist()
        ];
        return view("SubmissionManagement::events.new", $data);
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $event = SubmissionEvent::find($id);

            if(!empty($request->get('parent_id'))) {
                $event->parent_id = $request->get('parent_id');
            } else {
                $event->parent_id = null;
            }
            $event->updated_by = Auth::user()->id;
            $event->update($request->all());
            return response()->json([$event]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    protected function validator(Request $request) {
        if(!empty($request->get('hasparent'))) {
            $parent = SubmissionEvent::findOrFail($request->get('parent_id'));
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:modules,name,' . $request->id,
                'parent_id' => 'required|numeric|max:255',
                'description' => 'required|string|max:255',
                'valid_from'    => "required|date_format:Y-m-d|after_or_equal:{$parent->valid_from->format('Y-m-d')}",
                'valid_thru'    => "required|date_format:Y-m-d|before_or_equal:{$parent->valid_thru->format('Y-m-d')}",
            ],[
                'valid_from.after_or_equal' => 'Must between parent valid date',
                'valid_thru.before_or_equal' => 'Must between parent valid date'
            ]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:modules,name,' . $request->id,
                'description' => 'required|string|max:255',
                'valid_from'    => 'required|date_format:Y-m-d',
                'valid_thru'    => 'required|date_format:Y-m-d',
            ]);
        }

    }

    public function store(Request $request) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $submissionevent = new SubmissionEvent();
            $submissionevent = $submissionevent->create($request->all());
            $submissionevent->created_by = Auth::user()->id;
            $submissionevent->updated_by = Auth::user()->id;
            if(!empty($request->get('parent'))) {
                $submissionevent->parent_id = $request->get('parent');
            }
            $submissionevent->valid_thru = $submissionevent->valid_thru->addDay(1)->subSecond(1);
            $submissionevent->update();
            return response()->json([$submissionevent]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


}