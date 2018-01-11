<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 10:47
 */

namespace App\Modules\User\Controllers\Submission;

use App\Helper\AppHelper;
use App\Helper\Constant;
use App\Helper\HtmlHelper;
use App\Http\Controllers\Controller;
use App\Models\BaseModel\SystemSetting;
use App\Models\BaseModel\User;
use App\Modules\SubmissionManagement\Models\SubmissionEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\BaseModel\Submission;
use Illuminate\Http\Request;
use DB;

class MainController extends Controller
{
    public function index() {
        return view("User::submission.index");
    }

    public function register() {
        $eventlist = SubmissionEvent::getlist();
        return view('User::submission.register', compact('eventlist'));
    }

    public function submit(Request $request) {
        $validator = $this->submissionValidation($request);
        if($validator->passes()) {
            $uploadedfile = $request->file('file');
            $path = $uploadedfile->store('public/abstract');

            $submission = new Submission();

            $submission->create([
                    'title'         => $request->get('title'),
                    'abstract'      => $request->get('abstract'),
                    'abstractfile'  => $path,
                    'user_id'       => Auth::id(),
                    'workstate_id'  => Constant::ABSTRACT_REVIEW,
                    'submission_event_id'  => $request->get('submission_event_id'),
                ]
            );

            return response()->json(['success' => true, 'redirect' => route('user.submission.list')]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }

    public function submissionValidation(Request $request) {
        return Validator::make($request->all(), [
            'title'                 => 'required|string|max:255|',
            'abstract'              => 'required|string',
            'file'                  => 'required|file|mimes:pdf,doc,docx|max:2048',
            'submission_event_id'   => 'required',
        ]);
    }

    public function abstractReupload(Request $query, $id) {
        $submission = User::find(Auth::id())->submissions()->findOrFail($id);
        return view("User::submission.reupload", compact('submission'));
    }

    public function reupload(Request $request) {
        $submission = User::find(Auth::id())->submissions()->findOrFail($request->get('id'));
        $validator = $this->submissionValidation($request);
        if($validator->passes()) {
            $uploadedfile = $request->file('file');
            $path = $uploadedfile->store('public/abstract');

            $submission->update([
                    'title'         => $request->get('title'),
                    'abstract'      => $request->get('abstract'),
                    'abstractfile'  => $path,
                    'user_id'       => Auth::id(),
                ]
            );

            return response()->json(['success' => true, 'redirect' => route('user.submission.list')]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }

    public function DTSubmission(Request $request) {
        $user = Auth::user();
        DB::statement(DB::raw('set @rownum=0'));
        $submission = User::find($user->id)->submissions()
            ->select([
                DB::raw("@rownum := @rownum + 1 AS row") ,
                "id",
                "title",
                "abstract",
                "user_id",
                "workstate_id",
                "abstractfile",
                "submission_event_id",
                "submission_status_id",
                "approved",
                "file_paper_id"
            ])
            ->with(['user','workstate','submission_event','file_paper']);

        $datatable = app('datatables')->of($submission)
            ->editColumn('workstate.name', function($s) {
                $sub = Submission::find($s->id);
                return !empty($sub->workstate) ? $sub->workstate->name : "Unavailable" ;
            })
            ->addColumn('file_abstract', function($s) {

                $btn = HtmlHelper::linkButton("Abstract", route('user.submission.getabstract', $s->id) , 'btn-xs btn-info btn-download', '',"glyphicon-download");
                $btn .= "<br><br>";
                $btn .= HtmlHelper::linkButton('Reupload', route('user.submission.abstractreupload', $s->id), 'btn-xs btn-primary','target="_blank"', "glyphicon-upload");
                return $btn;
            })
            ->addColumn('action', function($s) {
                if(!empty($s->file_paper)) {
                    $text = "Re-upload";
                } else {
                    $text = "Upload";
                }

                if($s->approved && $s->isPaid()) {
                    $btn = HtmlHelper::linkButton($text, route('user.submission.upload', $s->id), 'btn-xs btn-info btn-modal', "data-id='{$s->id}'", "glyphicon-upload");
                    return $btn;
                } else if($s->approved && !$s->isPaid()) {
                    $msg = "You have not made a payment. Please confirm your payment to unlock upload.";
                    $btn = HtmlHelper::linkButton($text,"#", "btn-xs btn-info btn-disabled","data-toggle='tooltip' title='{$msg}' disabled", 'glyphicon-upload');
                    return $btn . "<br><i>*Not Paid</i>";
                } else {
                    return "Not Yet Approved";
                }
            })
            ->rawColumns(['file_abstract','action']);



        return $datatable->make(true);
    }

    public function getAbstractFile($id) {
        $sub = User::find(Auth::id())->submissions()->findOrFail($id);
        $ext = AppHelper::getFileExtension($sub->abstractfile);
        $file = public_path(Storage::url($sub->abstractfile));
        return response()->download($file, join(".", [str_replace(' ', '_', $sub->title), $ext]));
    }

}