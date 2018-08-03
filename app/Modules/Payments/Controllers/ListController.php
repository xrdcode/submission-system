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
        $submission = Submission::where('approved','=',1)
            ->whereHas('submission_event', function($q) {
                $q->where('valid_from','<=', Carbon::now())
                    ->where('valid_thru','>=', Carbon::now());
            })->whereHas('user', function($q) {
                $q->where('deleted', 0);
            })
            ->has('payment_submission')->with(['payment_submission.pricing','submission_event','submission_type','user']);

        $dt = Datatables::of($submission);

        $dt->editColumn('payment_submission.verified', function($s){
            if(!$s->payment_submission->verified && !empty($s->payment_submission->file)) {
                $row  = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $s->payment_submission->verified ? "Verified" : "Not Yet");
                $list = [1 => 'Approved', 0 => 'Not yet'];
                $row .= HtmlHelper::selectList($list, $s->verified, "verified", "form-control hide-n-seek", ["data-action" => route('admin.payment.verify', $s->id), "data-id" => $s->id, "style" => "display:none"]);
            } else {
                $row  = HtmlHelper::createTag("i",[],[], $s->payment_submission->verified ? "Verified" : "Not Yet");
            }
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
        $gp = GeneralPayment::select(["id","submission_event_id","verified","notes","workstate_id","user_id","pricing_id","file"])
            ->whereHas('user', function($q) {
                $q->where('deleted', 0);
            })->with(['submission_event','pricing','workstate','user']);

        $dt = Datatables::of($gp);

        $dt->addColumn('receipt', function($gp) {
            $file = $gp->file;
            if(empty($file))
                return "Not yet uploaded";
            return HtmlHelper::createTag("a",['btn','btn-xs','btn-info', 'btn-modal'],['href' => route('admin.payment.wsreceipt', $gp->id)],"View");
        });

        $dt->editColumn('verified', function($gp) {
            if(!$gp->isPaid() && !empty($gp->file)) {
                $row  = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $gp->verified);
                $list = GeneralPayment::VERIFIED;
                $row .= HtmlHelper::selectList($list, GeneralPayment::VERIFIED_R[$gp->verified], "verified", "form-control hide-n-seek", ["data-action" => route('admin.payment.wsverify', $gp->id), "data-id" => $gp->id, "style" => "display:none"]);
            } else {
                $row  = HtmlHelper::createTag("i",[],[], $gp->verified);
            }
            return $row;
        });

        $dt->rawColumns(['action','verified','receipt']);

        return $dt->make(true);
    }
}