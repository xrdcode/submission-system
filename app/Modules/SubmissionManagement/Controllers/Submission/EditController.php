<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\SubmissionManagement\Controllers\Submission;


use App\Http\Controllers\Controller;

use App\Models\BaseModel\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Carbon\Carbon;

class EditController extends Controller
{

    public function __construct()
    {
        //$this->middleware(['role:SubmissionManagement-Create'])->only(['store','newprice']);
        //$this->middleware(['role:SubmissionManagement-Save'])->only(['update','index','setprogress']);
        //$this->middleware(['role:SubmissionManagement-MinimumSaveAccess'])->only(['setprogress']);
    }

    public function index($id) {
        $submission = Submission::findOrFail($id);
        $data = [
            'action'        => route('admin.pricing.update', $id),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'pricingmodal',
            'title'         => 'Edit Submission',
            'pricing'       => $submission
        ];
        return view("SubmissionManagement::pricing.medit", $data);
    }


    public function newprice() {
        $data = [
            'action'        => route('admin.pricing.store'),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'pricingmodel',
            'title'         => 'Create New Price',
            'eventlist'    => Submission::getEventList(),
            'typelist'    => ScheduleType::getList()
        ];
        return view("SubmissionManagement::pricing.new", $data);
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $submission = Submission::find($id);

            $submission->updated_by = Auth::user()->id;

            $submission->update($request->only(['price','submission_event_id','pricing_types']));
            return response()->json([$submission]);
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

    public function setprogress(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'workstate_id'  => 'required|numeric',
            'id'            => 'required|numeric'
        ]);

        if($validator->passes()) {
            $submission = Submission::findOrFail($request->get('id'));
            $submission->workstate_id = $request->get('workstate_id');
            $status = $submission->update();
            return response()->json(["success" => $status , $submission]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function setapproved(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'approved'      => 'required|numeric',
            'id'            => 'required|numeric'
        ]);

        if($validator->passes()) {
            $submission = Submission::findOrFail($request->get('id'));
            $submission->approved = $request->get('approved');
            $status = $submission->update();
            return response()->json(["success" => $status , $submission]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


}