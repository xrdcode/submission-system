<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 10/01/2018
 * Time: 18:24
 */

namespace App\Modules\Payments\Controllers\Submission;

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
        return view("Payments::submission.index");
    }

    public function DT() {
        $submission = Submission::where('approved','=',1)
            ->whereHas('submission_event', function($q) {
                $q->where('valid_from','<=', Carbon::now())
                    ->where('valid_thru','>=', Carbon::now());
            })
            ->has('payment_submission')->with(['payment_submission.pricing','submission_type','submission_event','user']);

        $dt = Datatables::of($submission);


        $dt->addColumn('payment', function($s) {
            if($s->approved && empty($s->payment_submission)) {
                return HtmlHelper::linkButton('Assign', route('admin.payment.submission.assign', $s->id), 'btn-xs btn-primary btn-edit', '');
            } else {
                if($s->approved) {
                    if(!$s->isPaid()) {
                        return HtmlHelper::linkButton('Re-Assign', route('admin.payment.submission.assign', $s->id), 'btn-xs btn-primary btn-edit', '');
                    } else {
                        return "Paid";
                    }
                }
                return "";
            }
        });


        $dt->rawColumns(['payment','progress']);

        return $dt->make(true);
    }
}