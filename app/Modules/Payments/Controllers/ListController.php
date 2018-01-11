<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 10/01/2018
 * Time: 18:24
 */

namespace App\Modules\Payments\Controllers;

use App\Models\BaseModel\PaymentSubmission;
use App\Models\BaseModel\Submission;
use App\Http\Controllers\Controller;
use App\Constants;
use Illuminate\Support\Facades\Storage;
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
        $payment = PaymentSubmission::findOrFail($id);
        $file = Storage::url($payment->file);
        return view("Payments::imageview", compact('file'));
    }

    public function DT() {
        $submission = Submission::where('approved','=',1)
            ->whereHas('submission_event', function($q) {
                $q->where('valid_from','<=', Carbon::now())
                    ->where('valid_thru','>=', Carbon::now());
            })
            ->has('payment_submission')->with(['payment_submission.pricing','submission_event','user']);

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


        $dt->rawColumns(['verified','receipt']);

        return $dt->make(true);
    }
}