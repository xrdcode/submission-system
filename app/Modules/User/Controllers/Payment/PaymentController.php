<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 10:46
 */

namespace App\Modules\User\Controllers\Payment;

use App\Helper\HtmlHelper;
use App\Http\Controllers\Controller;
use App\Models\BaseModel\Submission;
use App\Models\BaseModel\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class PaymentController extends Controller
{
    public function index() {
        return view("User::payment.index", $this->data);
    }

    public function non_participant_index() {
        $this->data['header'] = "Non Participant";
        return view("User::payment.nonparticipant", $this->data);
    }

    public function non_participant_apply() {
        return view("User::payment.applynonparticipant");
    }

    public function DTWaitingPayment() {
        $submission = User::findOrFail(Auth::id())->submissions();
        $submission->where('approved','=', 1)->has('payment_submission')->with(['workstate','payment_submission.pricing']);

        $dt = Datatables::of($submission);

        $dt->addColumn("action", function($s) {
            return "";
        });

        $dt->addColumn('file_abstract', function($s) {

            $btn = HtmlHelper::linkButton("Abstract", route('user.submission.getabstract', $s->id) , 'btn-xs btn-info btn-download', '',"glyphicon-download");
            $btn .= "<br><br>";
            $btn .= HtmlHelper::linkButton('Reupload', route('user.submission.abstractreupload', $s->id), 'btn-xs btn-primary','target="_blank"', "glyphicon-upload");
            return $btn;
        });

        $dt->addColumn("confirm", function($s) {

            if($s->isPaid()) {
                if(!$s->payment_submission->verified)
                    return "Reupload";
                return HtmlHelper::createTag('i', [],[],'Already Verified');
            } else {
                if(empty($s->payment_submission->file)) {
                    $text = "Upload Confirmation";
                    $class = "btn-xs btn-warning btn-modal";
                } else {
                    $text = "Re-upload confirmation";
                    $class = "btn-xs btn-success btn-modal";
                }
                return HtmlHelper::linkButton($text, route('user.payment.upload', $s->id),$class,"data-id='{$s->id}'",'glyphicon-upload');
            }
        });


        $dt->rawColumns(['confirm','file_abstract']);
        return $dt->make(true);
    }

    ////// MODAL /////////

    public function _ModalUploadConfirmation($id) {
        $data = [
            'class'     => 'modal-sm',
            'action'    => route('user.payment.save', $id),
            'p'         => User::find(Auth::id())->submissions()->findOrFail($id)->payment_submission
        ];

        return view('User::payment.confirmation', $data);
    }

    public function uploadConfirmation(Request $request) {
        $validator = Validator::make($request->all(), [
            'submission_id' => 'required|numeric|exists:submissions,id',
            'file'   => 'required|file|mimes:jpeg,jpg,png|max:500'
        ]);

        if($validator->passes()) {
            $uploadedfile = $request->file('file');
            $path = $uploadedfile->store('public/confirmtrx');
            $ps = Auth::user()->submissions()->findOrFail($request->id)->payment_submission;
            $old = $ps->file;
            $ps->file = $path ;
            $ps->update();
            if(!empty($old))
                unlink(public_path(Storage::url($old)));
            return response()->json(['success' => true]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }
}