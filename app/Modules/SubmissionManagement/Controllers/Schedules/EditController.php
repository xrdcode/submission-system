<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\SubmissionManagement\Controllers\Schedules;


use App\Http\Controllers\Controller;

use App\Models\BaseModel\EventSchedule;
use App\Modules\SubmissionManagement\Models\SubmissionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Carbon\Carbon;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:ScheduleManagement-Create'])->only(['store','newprice']);
        $this->middleware(['role:ScheduleManagement-Save'])->only(['update','index','activate']);
    }

    public function index($id) {
        $schedules = EventSchedule::findOrFail($id);
        $data = [
            'action'        => route('admin.pricing.update', $id),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'pricingmodal',
            'title'         => 'Edit Schedule',
            'pricing'       => $schedules
        ];
        return view("SubmissionManagement::pricing.medit", $data);
    }


    public function newprice() {
        $data = [
            'action'        => route('admin.pricing.store'),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'pricingmodel',
            'title'         => 'Create New Price',
            'eventlist'    => EventSchedule::getEventList(),
            'typelist'    => ScheduleType::getList()
        ];
        return view("SubmissionManagement::pricing.new", $data);
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $schedule = EventSchedule::find($id);

            $schedule->updated_by = Auth::user()->id;

            $schedule->update($request->only(['price','submission_event_id','pricing_types']));
            return response()->json([$schedule]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


    protected function validator(Request $request) {
        return Validator::make($request->all(), [
            'title'         => 'required|string|max:150',
            'description'   => 'required|string|max:1000',
            'notes'         => 'required|string|max:1000',
            'detail'        => 'required|string|max:1000',
            'valid_from'    => 'before_or_equal:valid_thru',
            'valid_thru'    => 'after_or_equal:valid_from',
        ]);
    }

    public function store(Request $request) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $find = EventSchedule::where('submission_event_id','=', $request->get('submission_event_id'))
                ->where('pricing_type_id','=',$request->get('pricing_type_id'))->first();
            if(!empty($find)) {
                $schedule = $find;
                $schedule->update($request->all());
            } else {
                $schedule = new Schedule();
                $schedule = $schedule->create($request->all());
                $schedule->created_by = Auth::user()->id;
                $schedule->updated_by = Auth::user()->id;
                $schedule->update();
            }
            return response()->json([$schedule]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


}