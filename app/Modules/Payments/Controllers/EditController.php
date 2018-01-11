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

            return response()->json(["success" => $status , $submission]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


}