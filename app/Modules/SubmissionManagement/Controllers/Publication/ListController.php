<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 4:46
 */

namespace App\Modules\SubmissionManagement\Controllers\Publication;

use App\Helper\AppHelper;
use App\Helper\HtmlHelper;
use App\Models\BaseModel\Submission;
use App\Models\BaseModel\Workstate;
use App\Modules\AdminManagement\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:PublicationManagement-View');
    }

    public function index() {
        $list = Submission::all();
        return view('SubmissionManagement::publication.index', ['list' => $list]);
    }


    public function DT(Request $request) {
        $approved = !empty($request->get('a')) ? $request->get('a') : 0;
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
                "file_paper_id"])->has("user");
        if(Auth::user()->hasGroup('Reviewer') && !Auth::user()) {
            $submission->whereIn('id', Auth::user()->taskList());
        }
        $submission->where('approved', $approved);
        $submission->where('ispublicationonly','=',1)->with(['user','submission_event','payment_submission','submission_type','payment_submission.pricing']);


        $datatable = Datatables::of($submission)
            ->editColumn('approved', function($s) {
                $row = '';

                if(empty($s->file_paper)) {
                    $row .= HtmlHelper::createTag('button', ['btn btn-xs btn-info disabled'] , ['id' => "#pub{$s->id}","disabled" => true , "data-id" => $s->id], 'Approve');
                } else
                if(!$s->approved) {
                    $row .= HtmlHelper::createTag('a',['btn btn-xs btn-info btn-modal'],['href' => route('admin.publication.setpublication', $s->id)], 'Approve');
                } else {
                    $row .= HtmlHelper::createTag('button', ['btn btn-xs btn-info disabled'] , ['id' => "#pub{$s->id}","disabled" => true , "data-id" => $s->id], 'Approved');
                }
                return $row;
            })
            ->addColumn('progress', function($s) {
                $ws = Workstate::getList(1);
                $w = $s->workstate;
                $url = route('admin.publication.progress', $s->id);
                $row = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $w->name);
                $row .= HtmlHelper::selectList($ws, $s->workstate_id ,'workstate_id','form-control hide-n-seek',["data-action" => $url,"data-id" => $s->id, "style" => "display:none"]);
                return $row;
            });

//        $datatable->addColumn('payment', function($s) {
//            if($s->approved && empty($s->payment_submission)) {
//                return HtmlHelper::linkButton('Assign', route('admin.publication.payment', $s->id), 'btn-xs btn-primary btn-edit', '');
//            } else {
//                if($s->approved) {
//                    if(!$s->isPaid()) {
//                        return HtmlHelper::linkButton('Re-Assign', route('admin.publication.payment', $s->id), 'btn-xs btn-primary btn-edit', '');
//                    } else {
//                        return "Paid";
//                    }
//
//                }
//                return "";
//            }
//        });

        $datatable->editColumn('feedback', function($s) {
            $url = route('admin.publication.setfeedback', $s->id);
            $row = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $s->feedback ?: "Click to give feedback");
            $row .= HtmlHelper::createTag("textarea",['form-control','hide-n-seek'],["name" => "feedback",'data-action' => $url, "data-id" => $s->id, "style" => "display:none"], $s->feedback);
            return $row;
        });

//        $datatable->addColumn('file_abstract', function($s) {
//            $btn = HtmlHelper::linkButton("Abstract", route('admin.publication.getabstract', $s->id) , 'btn-xs btn-info btn-download', '',"glyphicon-download");
//            $btn .= "<br>";
//            $btn .= HtmlHelper::linkButton('View', route('admin.publication.abstract', $s->id), "btn-xs btn-info btn-modal", "", "glyphicon-view");
//            return $btn;
//        });

        if(Auth::user()->hasGroup('Editor, SuperAdmin')) {
            $datatable->addColumn('reviewer', function($s) {
                $btn = "";
                if(empty($s->reviewer())) {
                    $btn .= HtmlHelper::linkButton(' Assign',route('admin.publication.assignrev', $s->id), 'btn-xs btn-default btn-modal','','glyphicon-user');
                } else {
                    $btn .= HtmlHelper::createTag('i',[],['style' => 'padding:5px 5px 0px 0px'],$s->reviewer->name);
                    $btn .= HtmlHelper::linkButton(' Change',route('admin.publication.assignrev', $s->id), 'btn-xs btn-default btn-modal','','glyphicon-user');
                }
                return $btn;
            });
        }

        $datatable->addColumn('file_paper', function($s) {
            if(!empty($s->file_paper)) {
                $btn = HtmlHelper::linkButton("Paper", route('admin.publication.getpaper', $s->id), 'btn-xs btn-success btn-download', "",'glyphicon-download');
                return $btn;
            } else {
                return "Not Yet Uploaded";
            }
        });

        $datatable->rawColumns(['progress','approved','payment','file_abstract','feedback','file_paper','reviewer']);

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
        return view("SubmissionManagement::publication.abstractdetail", $data);
    }


}