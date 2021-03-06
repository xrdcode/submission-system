<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\SubmissionManagement\Controllers\Submission;


use App\Helper\Constant;
use App\Http\Controllers\Controller;

use App\Jobs\SendAbstractApprovedEmail;
use App\Mail\AbstractApprovedNotification;
use App\Models\BaseModel\PaymentSubmission;
use App\Models\BaseModel\Submission;
use App\Models\BaseModel\User;
use App\Modules\SubmissionManagement\Models\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;
use Carbon\Carbon;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:SubmissionManagement-Save'])->only(['index', 'update']);
        $this->middleware(['role:SubmissionManagement-MinimumSaveAccess'])->only(['setprogress','setapproved','setpayment','_ModalAssignPayment']);
    }

    public function index($id) {

    }


    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $submission = Submission::findOrFile($id);

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
            $user = User::find($submission->user_id);
            $user->createNotification("Submission Progress", "<strong>{$submission->title}</strong><br>Your submission progress changed to {$submission->workstate->name} by " . Auth::user()->name);
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

            $submission = new Submission();
            $submission = $submission->findOrFail($request->get('id'));

            DB::transaction(function() use ($submission, $request) {

                if($submission->ispublicationonly) {
                    $pricing = Pricing::findOrFail($submission->publication_id);
                } else {
                    $user = $submission->user->personal_data->student == 0 ? "Non-Student" : "Student";
                    $pricing = $submission->submission_event->pricings()
                        ->where("occupation","=",$user)->first();
                }

                if($submission->isPaid())
                    return response()->json(["success" => true , $submission]);
                if(empty($submission->payment_submission)) {
                    $payment_submission = new PaymentSubmission();
                    $payment_submission->pricing()->associate($pricing);
                    $payment_submission->submission()->associate($submission);
                    $payment_submission->save();
                }
                $submission->workstate_id = Constant::AFTER_PAID;
                $submission->approved = $request->get('approved');
                $status = $submission->update();

                $this->dispatch(new SendAbstractApprovedEmail($submission));
                $user = User::find($submission->user_id);
                $user->createNotification("Abstract Approved", "<strong>{$submission->title}</strong><br>Your abstract has been approved by reviewer " . Auth::user()->name);

                return response()->json(["success" => $status , $submission]);
            });



            return response()->json(["success" => false]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function setpayment(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'submission_id'  => 'required|numeric',
            'pricing_id'     => 'required|numeric',
        ]);

        if($validator->passes()) {
            $submission = Submission::findOrFail($id);
            if(empty($submission->payment_submission)) {
                $ps = new PaymentSubmission();
                $ps->create($request->all());
                $ps->created_by = Auth::id();
                $ps->modified_by = Auth::id();
                $submission->workstate_id = Constant::AFTER_APPROVED;
                $submission->update();
                $status = $ps->update();
            } else {
                $ps = $submission->payment_submission;
                $ps->updated_by = Auth::id();
                $status = $ps->update($request->all());
            }

            return response()->json(["success" => $status , $submission]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function setfeedback(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'id'  => 'required|numeric',
            'feedback'     => 'required|string',
        ]);

        if($validator->passes()) {
            $submission = Submission::findOrFail($id);
            $status = $submission->update($request->only('feedback'));
            $user = User::find($submission->user_id);
            $user->createNotification("Submission Feedback", "<strong>{$submission->title}</strong><br>You've got feedback from " . Auth::user()->name);
            return response()->json(["success" => $status]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    //////
    ///

    public function assignpub(Request $request, $id) {
        $submission = Submission::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'submission_id' => 'required|numeric',
            'pricing_id'    => 'required|numeric'
        ]);

        if($validator->passes()) {
            if(empty($submission->publication)) {
                DB::transaction(function() use ($submission, $request) {
                    $newpub = new Submission();
                    $pricing = Pricing::findOrFail($request->get('pricing_id'));
                    $newpub->ispublicationonly = 1;
                    $newpub->title = $submission->title;
                    $newpub->abstract = $submission->abstract;
                    $newpub->title = $submission->title;
                    $newpub->submission_event_id = $submission->submission_event_id;
                    $newpub->user_id = $submission->user_id;
                    $newpub->workstate_id = Constant::AFTER_PAID;
                    $newpub->submission_id = $request->get('submission_id');
                    $newpub->save();

                    $user = User::find($submission->user_id);
                    $user->createNotification("Submission Update", "<strong>{$submission->title}</strong><br>Your submission assigned to publication by " . Auth::user()->name);

                    $payment_submission = new PaymentSubmission();
                    $payment_submission->pricing()->associate($pricing);
                    $payment_submission->submission()->associate($newpub);
                    $payment_submission->save();
                });

            }
            return response()->json(["success" => true]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    //// MODAL ////

    /**
     * @param $id : submission id
     */
    public function _ModalAssignPayment($id) {
        $submission = Submission::findOrFail($id);
        $data = [
            'action'        => route('admin.submission.setpayment', $id),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'pricingmodal',
            'title'         => 'Assign Payment',
            'submission'       => $submission
        ];
        return view("SubmissionManagement::submission.massign", $data);
    }




}