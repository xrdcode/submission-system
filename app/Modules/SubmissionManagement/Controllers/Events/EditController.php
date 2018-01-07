<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\SubmissionManagement\Controllers\Events;


use App\Http\Controllers\Controller;

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

            if(!empty($request->get('parent'))) {
                $event->parent_id = $request->get('parent');
            } else {
                $event->parent_id = null;
            }

            $event->updated_at = Carbon::now()->toDateTimeString();
            $event->updated_by = Auth::user()->id;

            if(!empty($event->parent_id)) {
                $event->valid_from = $event->parent->valid_from;
                $event->valid_thru = $event->parent->valid_thru;
            } else {
                $event->valid_from = $request->get('valid_from');
                $event->valid_thru = $request->get('valid_thru');
            }

            $event->update($request->only(['name','description']));
            return response()->json([$event]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function activate($id) {
        $module = Module::find($id);
        $module->active = true;
        return response()->json($module->saveOrFail());
    }

    protected function validator(Request $request) {
        if(!empty($request->get('hasparent'))) {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:modules,name,' . $request->id,
                'parent_id' => 'required|numeric|max:255',
                'description' => 'required|string|max:255',
            ]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:modules,name,' . $request->id,
                'description' => 'required|string|max:255',
            ]);
        }

    }

    /**
     * Minmal usia pendaftar 17tahun
     * @return string
     */
    protected function maxYear() {
        return Carbon::now()->addYears('-17')->addDays('1')->toDateString();
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
            $submissionevent->update();
            return response()->json([$submissionevent]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


}