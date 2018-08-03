<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 10:46
 */

namespace App\Modules\User\Controllers\Payment;

use App\Helper\AppHelper;
use App\Helper\HtmlHelper;
use App\Http\Controllers\Controller;
use App\Models\BaseModel\PaymentSubmission;
use App\Models\BaseModel\Submission;
use App\Models\BaseModel\User;
use Carbon\Carbon;
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

    public function DTWaitingPayment() {
        $submission = User::findOrFail(Auth::id())->submissions();
        $submission->where('approved','=', 1)->with(['workstate']);

        $dt = Datatables::of($submission);

        $dt->addColumn("action", function($s) {
            return "";
        });

        $dt->addColumn('file_abstract', function($s) {

            $btn = HtmlHelper::linkButton("Abstract", route('user.conference.getabstract', $s->id) , 'btn-xs btn-info btn-download', '',"glyphicon-download");
            $btn .= "<br><br>";
            $btn .= HtmlHelper::linkButton('Reupload', route('user.conference.abstractreupload', $s->id), 'btn-xs btn-primary','target="_blank"', "glyphicon-upload");
            return $btn;
        });

        $dt->addColumn('price', function ($s) {
            $user = $s->user->personal_data->student == 0 ? "Non-Student" : "Student";
            $submission_type = $s->submission_type_id == 1 ? "Presenter" : "Non Presenter"; // 1 presenter or 2 not presenter
            $pricing = $s->submission_event->pricings()
                ->where("title","LIKE", "{$submission_type}%")
                ->where("occupation","=",$user)
                ->orderBy("price", "desc")->first();
            if(!empty($s->payment_submission)) {
                switch ($s->payment_submission->price_copy) {
                    case $pricing->price:
                        return "Rp." . AppHelper::formatCurrency($s->payment_submission->price_copy) . " - Normal";
                    case $pricing->early_price:
                        return "Rp." . AppHelper::formatCurrency($s->payment_submission->price_copy) . " - Early";
                    default:
                        return "Rp." . AppHelper::formatCurrency($s->payment_submission->price_copy);
                }
            }

            if (Carbon::now() < $pricing->early_date_until) {
                return "Rp. " . AppHelper::formatCurrency($pricing->early_price, ".") . " - Early";
            } else {
                return "Rp." . AppHelper::formatCurrency($pricing->price, ".") . " - Normal";
            }
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
            'p'         => User::find(Auth::id())->submissions()->findOrFail($id)
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
            $submission = Auth::user()->submissions()->findOrFail($request->id);
            $ps = $submission->payment_submission;
            if (empty($ps)) {
                $user = $submission->user->personal_data->student == 0 ? "Non-Student" : "Student";
                $submission_type = $submission->submission_type_id == 1 ? "Presenter" : "Non Presenter"; // 1 presenter or 2 not presenter
                $pricing = $submission->submission_event->pricings()
                    ->where("title","LIKE", "{$submission_type}%")
                    ->where("occupation","=",$user)
                    ->orderBy("price", "desc")->first();

                if(empty($pricing)) {
                    return response()->json(['data' => $request->all(),'errors' => 'Price Not Found'], 200);
                }

                $ps = new PaymentSubmission();
                $ps->file = $path;
                $ps->pricing()->associate($pricing);
                $ps->submission()->associate($submission);
                $ps->price_copy = $pricing->price;
                $ps->save();
            } else {
                $old = $ps->file;
                $ps->file = $path ;
                $ps->update();
                if(!empty($old))
                    unlink(public_path(Storage::url($old)));
            }
            return response()->json(['success' => true]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }
}