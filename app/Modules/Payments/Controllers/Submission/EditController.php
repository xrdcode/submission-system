<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\Payments\Controllers\Submission;


use App\Helper\Constant;
use App\Http\Controllers\Controller;

use App\Models\BaseModel\PaymentSubmission;
use App\Models\BaseModel\Submission;
use App\Models\BaseModel\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Carbon\Carbon;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:PaymentManagement-Save']);
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

    //// MODAL ////

    /**
     * @param $id : submission id
     */
    public function _ModalAssignPayment($id) {
        $submission = Submission::findOrFail($id);
        $data = [
            'action'        => route('admin.payment.submission.setpayment', $id),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'pricingmodal',
            'title'         => 'Assign Payment',
            'submission'       => $submission
        ];
        return view("PaymentManagement::submission.massign", $data);
    }


}