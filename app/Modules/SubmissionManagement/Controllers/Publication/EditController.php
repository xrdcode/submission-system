<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\SubmissionManagement\Controllers\Publication;


use App\Helper\Constant;
use App\Http\Controllers\Controller;

use App\Models\BaseModel\PaymentSubmission;
use App\Models\BaseModel\Submission;
use App\Models\BaseModel\User;
use App\Modules\AdminManagement\Models\Admin;
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
        $this->middleware(['role:PublicationManagement-Save'])->only(['index', 'update']);
        $this->middleware(['role:PublicationManagement-MinimumSaveAccess'])->only(['setprogress','setapproved','setpayment','_ModalAssignPayment']);
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

            $publication = new Submission();
            $publication = $publication->findOrFail($request->get('id'));

            DB::transaction(function() use ($publication, $request) {

                $publication->approved = $request->get('approved');

                if($publication->approved && !Auth::user()->hasGroup('SuperAdmin'))
                    return response()->json(["success" => true]);

                $publication->save();

                return response()->json(["success" => true]);
            });


            return response()->json(["success" => false]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function setPricePublication(Request $request, $id) {
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
                $submission->approved = 1;
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
            return response()->json(["success" => $status]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function assign_rev(Request $request, $id) {
        $admin = Admin::find($request->get('admin_id'));
        $submission = Submission::findOrFail($id);
        return response()->json(['success' => $submission->assignReviewer($admin)]);
    }

    //// MODAL ////

    /**
     * @param $id : submission id
     */
    public function _ModalSetPublication($id) {
        $publication = Submission::findOrFail($id);
        $data = [
            'action'        => route('admin.publication.setpublication', $id),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'pricingmodal',
            'title'         => 'Approve & Choose Publication',
            'publication'       => $publication
        ];
        return view("SubmissionManagement::publication.msetpublication", $data);
    }

    public function _ModalAssignToReviewer($id) {

        $data = [
            'action'        => route('admin.publication.assignrev', $id),
            'class' => 'modal-sm', //Kelas Modal
            'title'         => 'Assign a Reviewer',
            'publication'       => Submission::where('id', $id)->where('ispublicationonly', 1)->first()
        ];
        return view("SubmissionManagement::publication.massignreviewer", $data);
    }


}