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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;
use Yajra\Datatables\Datatables;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:SubmissionManagement-View');
    }

    public function index(Request $request) {

        if ($request->get("export") == 1) {
            return App::make("excel")->create("Submission Review", function($x) {
                $x->sheet("Submission", function($s) {
                    $submission = Submission::query()
                        ->join("submission_events","submission_events.id", "=","submissions.submission_event_id")
                        ->join("users","users.id","=","submissions.user_id")
                        ->join("submission_types","submission_types.id","=","submissions.submission_type_id")
                        ->select([
                            "submissions.id",
                            "submissions.title",
                            "submissions.abstract",
                            "submissions.abstractfile",
                            "submissions.user_id",
                            "submissions.workstate_id",
                            "submissions.submission_event_id",
                            "submissions.submission_type_id",
                            "submissions.approved",
                            "submissions.feedback",
                            "submissions.submission_id",
                            "submissions.file_paper_id",
                            "submission_types.name as type_name",
                            "submission_events.name as event_name",
                            "users.name as user_name",
                            "submissions.publication_id",
                            "submissions.submission_id"
                        ])->get();

                    $data = [];
                    $i = 0;
                    foreach ($submission as $sub) {
                        $data[$i]["Event"] = $sub->event_name;
                        $data[$i]["Title"] = $sub->title;
                        $data[$i]["User"] = $sub->user_name;
                        $data[$i]["Type"] = $sub->type_name;
                        $data[$i]["Abstract"] = $sub->abstract;
                        $data[$i]["Abstract Link"] = url($sub->abstractfile);
                        $data[$i]["FeedBack"] = $sub->feedback;
                        $data[$i]["Approved"] = $sub->approved == 1 ? "Yes" : "Not Yet";
                        $i++;
                    }

                    $s->fromArray($data);
                });
            })->download();
        }
        return view('SubmissionManagement::submission.index');
    }

    public function DT(Request $request) {
        $submission = Submission::query()
            ->join("submission_events","submission_events.id", "=","submissions.submission_event_id")
            ->join("users","users.id","=","submissions.user_id")
            ->join("submission_types","submission_types.id","=","submissions.submission_type_id")
            ->select([
                "submissions.id",
                "submissions.title",
                "submissions.abstract",
                "submissions.abstractfile",
                "submissions.user_id",
                "submissions.workstate_id",
                "submissions.submission_event_id",
                "submissions.submission_type_id",
                "submissions.approved",
                "submissions.feedback",
                "submissions.submission_id",
                "submissions.file_paper_id",
                "submission_types.name as type_name",
                "submission_events.name as event_name",
                "users.name as user_name",
                "submissions.publication_id",
                "submissions.submission_id"
            ]);

        $datatable = Datatables::of($submission)
            ->editColumn('approved', function($s) {
                if(!$s->isPaid() && empty($s->payment_submission)) {
                    $row  = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $s->approved ? "Approved" : "Not Yet");
                    $list = [1 => 'Approved', 0 => 'Not yet'];
                    $row .= HtmlHelper::selectList($list, $s->approved, "approved", "form-control hide-n-seek", ["data-action" => route('admin.submission.approve', $s->id), "data-id" => $s->id, "style" => "display:none"]);
                } else {
                    $row  = HtmlHelper::createTag("i",[],[], $s->approved ? "Approved" : "Not Yet");
                    if(empty($s->publication)) {
                        $row .= "<br/>" . HtmlHelper::createTag('a',['btn btn-xs btn-default btn-modal'],['href' => route('admin.submission.assignpub', $s->id), "style" => "margin-top: 5px"],'Send to <br/> Publication');
                    } else {
                        $row .= "<br>";
                        $row .= HtmlHelper::createTag("span",[],["style" => "font-size: 10px !important"], $s->publication->payment_submission->pricing->title);
                    }
                }
                return $row;
            })
            ->addColumn('progress', function($s) {
                $ws = Workstate::getList(1);
                $w = $s->workstate;
                $url = route('admin.submission.progress', $s->id);
                $row = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $w->name);
                $row .= HtmlHelper::selectList($ws, $s->workstate_id ,'workstate_id','form-control hide-n-seek',["data-action" => $url,"data-id" => $s->id, "style" => "display:none"]);
                return $row;
            });

//        $datatable->addColumn('payment', function($s) {
//            if($s->approved && empty($s->payment_submission)) {
//                return HtmlHelper::linkButton('Assign', route('admin.submission.payment', $s->id), 'btn-xs btn-primary btn-edit', '');
//            } else {
//                if($s->approved) {
//                    if(!$s->isPaid()) {
//                        return HtmlHelper::linkButton('Re-Assign', route('admin.submission.payment', $s->id), 'btn-xs btn-primary btn-edit', '');
//                    } else {
//                        return "Paid";
//                    }
//
//                }
//                return "";
//            }
//        });

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

//        $datatable->addColumn('publication', function($s) {
//            $btn = "";
//            if(empty($s->publication)) {
//                $btn .= HtmlHelper::createTag('a',['btn btn-xs btn-default btn-modal'],['href' => route('admin.submission.assignpub', $s->id)],'Send to Publication');
//                return $btn;
//            }
//            return $s->publication->payment_submission->pricing->title;
//        });

        $datatable->addColumn('file_paper', function($s) {
            if(!empty($s->file_paper)) {
                $btn = HtmlHelper::linkButton("Paper", route('admin.submission.getpaper', $s->id), 'btn-xs btn-success btn-download', "",'glyphicon-download');
                return $btn;
            } else {
                return "Not Yet Uploaded";
            }
        });

        $datatable->rawColumns(['progress','approved','payment','file_abstract','feedback','file_paper','publication']);

        return $datatable->make(true);
    }

    function getAbstractFile($id) {
        $sub = Submission::findOrFail($id);
        $ext = AppHelper::getFileExtension($sub->abstractfile);
        $file = public_path(Storage::url($sub->abstractfile));
        $filename = $sub->user->name . "-" . join(".", [str_replace(' ', '_', $sub->title), $ext]);
        return response()->download($file, $filename);
    }

    function getPaper($id) {
        $paper = Submission::findOrFail($id)->file_paper;
        if(empty($paper)) abort(404);
        $file = public_path(Storage::url($paper->path));
        return response()->download($file, $paper->name);
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

    public function _ModalAssignPub($id) {
        $submission = Submission::findOrFail($id);
        $data = [
            'class'         => 'modal-sm',
            'title'         => 'Send to Publication',
            'action'        => route('admin.submission.assignpub', $id),
            'modalId'       => 'pricingmodal',
            'submission'    => $submission
        ];
        return view("SubmissionManagement::submission.massignpub", $data);
    }
}