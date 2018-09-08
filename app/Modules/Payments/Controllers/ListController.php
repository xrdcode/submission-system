<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 10/01/2018
 * Time: 18:24
 */

namespace App\Modules\Payments\Controllers;

use App\Models\BaseModel\GeneralPayment;
use App\Models\BaseModel\PaymentSubmission;
use App\Models\BaseModel\Submission;
use App\Http\Controllers\Controller;
use App\Constants;
use App\Models\BaseModel\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\Helper\HtmlHelper;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:PaymentManagement-View');
    }

    public function index() {
        return view("Payments::index");
    }

    public function viewReceipt($id) {
        $payment = Submission::findOrFail($id)->payment_submission;
        $file = Storage::url($payment->file);
        return view("Payments::imageview", compact('file'));
    }

    public function wsViewReceipt($id) {
        $payment = GeneralPayment::findOrFail($id);
        $file = Storage::url($payment->file);
        return view("Payments::imageview", compact('file'));
    }

    public function DT() {
        $submission = Submission::join("submission_events as se", "se.id","=", "submissions.submission_event_id")
            ->join("users","users.id","=","submissions.user_id")
            ->join("payment_submissions as ps","ps.submission_id","=","submissions.id")
            ->join("submission_types as st", "st.id","=","submissions.submission_type_id")
            ->select([
                "submissions.id",
                "submissions.title",
                "submissions.user_id",
                "submissions.submission_event_id",
                "submissions.approved",
                "se.name as event",
                "users.name",
                "st.name as type"
            ])
            ->where("submissions.approved","=",1)
            ->where("users.deleted","=", 0);

        $dt = Datatables::of($submission);

        $dt->editColumn('verified', function($s){
//            if(!$s->payment_submission->verified && !empty($s->payment_submission->file)) {
                $row  = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $s->payment_submission->verified ? "Verified" : "Not Yet");
                $list = [1 => 'Approved', 0 => 'Not yet'];
                $row .= HtmlHelper::selectList($list, $s->verified, "verified", "form-control hide-n-seek", ["data-action" => route('admin.payment.verify', $s->id), "data-id" => $s->id, "style" => "display:none"]);
//            } else {
//                $row  = HtmlHelper::createTag("i",[],[], $s->payment_submission->verified ? "Verified" : "Not Yet");
//            }
            return $row;
        });

        $dt->addColumn('receipt', function($s) {
            $file = $s->payment_submission->file;
            if(empty($file))
                return "Not yet uploaded";
            return HtmlHelper::createTag("a",['btn','btn-xs','btn-info', 'btn-modal'],['href' => route('admin.payment.receipt', $s->id)],"View");
        });

        $dt->addColumn('payment', function($s) {
            if($s->approved && empty($s->payment_submission)) {
                return HtmlHelper::linkButton('Assign', route('admin.submission.payment', $s->id), 'btn-xs btn-primary btn-edit', '');
            } else {
                if($s->approved) {
                    if(!$s->isPaid()) {
                        return HtmlHelper::linkButton('Re-Assign', route('admin.submission.payment', $s->id), 'btn-xs btn-primary btn-edit', '');
                    } else {
                        return "Paid";
                    }

                }
                return "";
            }
        });


        $dt->rawColumns(['verified','receipt']);

        return $dt->make(true);
    }

    public function DTWs() {
        $gp = GeneralPayment::join("submission_events as se", "se.id","=","general_payments.submission_event_id")
            ->join("users", "users.id", "=","general_payments.user_id")
            ->join("workstates", "workstates.id", "=", "general_payments.workstate_id")
            ->join("pricings as p","p.id", "=","general_payments.pricing_id")
            ->select([
                "general_payments.id",
                "general_payments.submission_event_id",
                "general_payments.verified",
                "general_payments.notes",
                "general_payments.workstate_id",
                "general_payments.user_id",
                "general_payments.pricing_id",
                "general_payments.file",
                "workstates.name as state",
                "p.title",
                "users.name"
                ])
            ->where("users.deleted", "=", 0);

        $dt = Datatables::of($gp);

        $dt->addColumn('receipt', function($gp) {
            $file = $gp->file;
            if(empty($file))
                return "Not yet uploaded";
            return HtmlHelper::createTag("a",['btn','btn-xs','btn-info', 'btn-modal'],['href' => route('admin.payment.wsreceipt', $gp->id)],"View");
        });

        $dt->editColumn('verified', function($gp) {
//            if(!$gp->isPaid() && !empty($gp->file)) {
                $row  = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $gp->verified);
                $list = GeneralPayment::VERIFIED;
                $row .= HtmlHelper::selectList($list, GeneralPayment::VERIFIED_R[$gp->verified], "verified", "form-control hide-n-seek", ["data-action" => route('admin.payment.wsverify', $gp->id), "data-id" => $gp->id, "style" => "display:none"]);
//            } else {
//                $row  = HtmlHelper::createTag("i",[],[], $gp->verified);
//            }
            return $row;
        });

        $dt->rawColumns(['action','verified','receipt']);

        return $dt->make(true);
    }
}