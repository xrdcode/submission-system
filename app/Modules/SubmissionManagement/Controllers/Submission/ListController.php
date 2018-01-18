<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 4:46
 */

namespace App\Modules\SubmissionManagement\Controllers\Submission;

use App\Helper\AppHelper;
use App\Helper\HtmlHelper;
use App\Models\BaseModel\Submission;
use App\Models\BaseModel\Workstate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:SubmissionManagement-View');
    }

    public function index() {
        $list = Submission::all();
        return view('SubmissionManagement::submission.index', ['list' => $list]);
    }

    public function DT(Request $request) {
        $submission = Submission::select(
            [
                "id",
                "title",
                "abstract",
                "abstractfile",
                "user_id",
                "workstate_id",
                "submission_event_id",
                "submission_type_id",
                "approved",
                "feedback",
                "file_paper_id"])->with(['user','submission_event','workstate','file_paper','payment_submission','submission_type']);
        $datatable = Datatables::of($submission)
            ->editColumn('approved', function($s) {
                if(!$s->isPaid() && empty($s->payment_submission)) {
                    $row  = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $s->approved ? "Approved" : "Not Yet");
                    $list = [1 => 'Approved', 0 => 'Not yet'];
                    $row .= HtmlHelper::selectList($list, $s->approved, "approved", "form-control hide-n-seek", ["data-action" => route('admin.submission.approve', $s->id), "data-id" => $s->id, "style" => "display:none"]);
                } else {
                    $row  = HtmlHelper::createTag("i",[],[], $s->approved ? "Approved" : "Not Yet");
                }
                return $row;
            })
            ->addColumn('progress', function($s) {
                $ws = Workstate::getList();
                $w = $s->workstate;
                $url = route('admin.submission.progress', $s->id);
                $row = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $w->name);
                $row .= HtmlHelper::selectList($ws, $s->workstate_id ,'workstate_id','form-control hide-n-seek',["data-action" => $url,"data-id" => $s->id, "style" => "display:none"]);
                return $row;
            })->rawColumns(['progress','approved','payment','file_abstract','feedback']);

        $datatable->addColumn('payment', function($s) {
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

        $datatable->editColumn('feedback', function($s) {
            $url = route('admin.submission.setfeedback', $s->id);
            $row = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $s->feedback ?: "Click to give feedback");
            $row .= HtmlHelper::createTag("textarea",['form-control','hide-n-seek'],["name" => "feedback",'data-action' => $url, "data-id" => $s->id, "style" => "display:none"], $s->feedback);
            return $row;
        });

        $datatable->addColumn('file_abstract', function($s) {
            $btn = HtmlHelper::linkButton("Abstract", route('admin.submission.getabstract', $s->id) , 'btn-xs btn-info btn-download', '',"glyphicon-download");
            $btn .= "<br>";
            $btn .= HtmlHelper::linkButton('View', route('admin.submission.abstract', $s->id), "btn-xs btn-info btn-modal", "", "glyphicon-view");
            return $btn;
        });

        return $datatable->make(true);
    }

    function getAbstractFile($id) {
        $sub = Submission::findOrFail($id);
        $ext = AppHelper::getFileExtension($sub->abstractfile);
        $file = public_path(Storage::url($sub->abstractfile));
        $filename = $sub->user->name . "-" . join(".", [str_replace(' ', '_', $sub->title), $ext]);
        return response()->download($file, $filename);
    }

    //// MODAL ////

    /**
     * @param $id : submission id
     */
    public function _ModalViewAbstract($id) {
        $submission = Submission::findOrFail($id);
        $data = [
            'class'         => 'modal-lg',
            'modalId'       => 'pricingmodal',
            'title'         => $submission->title,
            'submission'    => $submission
        ];
        return view("SubmissionManagement::submission.abstractdetail", $data);
    }
}