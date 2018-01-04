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
        return view("EventsManagement::events.edit", compact('events'));
    }


    public function newevent() {
        $data = [
            'action' => route('admin.event.store'),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'   => 'eventmodal',
            'title'     => 'Create New Event'
        ];
        return view("SubmissionManagement::events.new", compact('data'));
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $event = SubmissionEvent::find($id);
            $event = $event->create($request->all());

            if(!empty($request->hasparent)) {
                $event->parent_id = $request->parent_id;
            }

            $event->updated_at = Carbon::now()->toDateTimeString();
            $event->updated_by = Auth::user()->id;
            $event->update($request->only(['name','description','pathname']));
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
        if(!empty($request->hasparent)) {
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
            $module = new Module();
            $module = $module->create($request->all());
            $module->created_by = Auth::user()->id;
            $module->updated_by = Auth::user()->id;
            $module->update();
            return response()->json([$module]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


}