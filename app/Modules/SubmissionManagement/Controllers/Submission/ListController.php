<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 4:46
 */

namespace App\Modules\SubmissionManagement\Controllers\Submission;

use App\Helper\HtmlHelper;
use App\Models\BaseModel\Submission;
use App\Models\BaseModel\Workstate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class ListController extends Controller
{
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
                "approved",
                "file_paper_id"])->with(['user','submission_event','workstate','file_paper']);
        $datatable = Datatables::of($submission)
            ->editColumn('approved', function($s) {
                $row  = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $s->approved ? "Approved" : "Not Yet");
                $list = [1 => 'Approved', 0 => 'Not yet'];
                $row .= HtmlHelper::selectList($list, $s->approved, "approved", "form-control hide-n-seek", ["data-action" => route('admin.submission.approve', $s->id), "data-id" => $s->id, "style" => "display:none"]);
                return $row;
            })
            ->addColumn('progress', function($s) {
                $ws = Workstate::getList();
                $w = Workstate::find($s->workstate_id);
                $url = route('admin.submission.progress', $s->id);
                $row = HtmlHelper::createTag("i",["click-edit"],["title"=>"click to change"], $w->name);
                $row .= HtmlHelper::selectList($ws, $s->workstate_id ,'workstate_id','form-control hide-n-seek',["data-action" => $url,"data-id" => $s->id, "style" => "display:none"]);
                return $row;
            })->rawColumns(['progress','approved']);
        return $datatable->make(true);
    }
}