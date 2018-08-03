<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\Payments\Controllers;


use App\Helper\Constant;
use App\Http\Controllers\Controller;

use App\Models\BaseModel\GeneralPayment;
use App\Models\BaseModel\PaymentSubmission;
use App\Models\BaseModel\Submission;
use App\Models\BaseModel\User;
use App\Models\BaseModel\WorkshopTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use Validator;
use Carbon\Carbon;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:PaymentManagement-Save']);
    }

    public function setverified(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'verified'      => 'required|numeric',
            'id'            => 'required|numeric'
        ]);

        if($validator->passes()) {
            $submission = new Submission();
            $submission = $submission->findOrFail($request->get('id'));


            if($submission->isPaid())
                return response()->json(["success" => true , $submission]);
            $submission->workstate_id = Constant::AFTER_PAID;

            $submission->payment_submission()->update($request->only(['verified']));
            $status = $submission->update();
            //$submission->create_publication();

            return response()->json(["success" => $status , $submission]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


    /**
     * Workshop
     */

    public function ws_setverified(Request $request) {
        $validator = Validator::make($request->all(), [
            'verified'      => 'required|numeric',
            'id'            => 'required|numeric'
        ]);

        if($validator->passes()) {
            $gp = new GeneralPayment();
            $gp = $gp->findOrFail($request->get('id'));
            $gp->workstate_id = Constant::WS_CONFIRMED;
            $gp->verified = $request->get('verified');
            $gp->update();
            if(empty($gp->workshop_ticket)) {
                $tiket = new WorkshopTicket();
                $tiket->code = Uuid::uuid4();
                $tiket->general_payment()->associate($gp);
                $tiket->save();
            }
            return response()->json(["success" => true]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


}