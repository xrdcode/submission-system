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
use App\Models\BaseModel\User;
use App\Modules\SubmissionManagement\Models\SubmissionEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\BaseModel\Submission;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        $this->data['header'] = "Submission List";
        return view("User::submission.index", $this->data);
    }

    public function register() {
        $this->data['header'] = "Apply Conference and Workshop";
        $eventlist = SubmissionEvent::getlist();
        $this->data['eventlist'] = $eventlist;
        return view('User::submission.register', $this->data);
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
                    'submission_event_id'           => $request->get('submission_event_id'),
                    'submission_type_id'            => $request->get('submission_type_id'),
                    'ispublicationonly' => false //Conference Participant
                ]
            );

            return response()->json(['success' => true, 'redirect' => route('user.submission')]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }

    public function submissionValidation(Request $request, $ispublication = false) {
        if($ispublication) {
            return Validator::make($request->all(), [
                'title'                 => 'required|string|max:255|unique:submissions,title',
                'abstract'              => 'required|string',
                'file'                  => 'required|file|mimes:doc,docx|max:2048',
                'submission_event_id'   => 'required|numeric',
                'publication_id'        => 'required|numeric'
            ]);
        } else {
            return Validator::make($request->all(), [
                'title'                 => 'required|string|max:255|unique:submissions,title',
                'abstract'              => 'required|string',
                'file'                  => 'required|file|mimes:doc,docx|max:2048',
                'submission_event_id'   => 'required|numeric',
                'submission_type_id'    => 'required|numeric',
            ]);
        }

    }

    public function abstractReupload(Request $query, $id) {
        $this->data['header'] = "Reupload Submission";
        $submission = User::find(Auth::id())->submissions()->findOrFail($id);
        $this->data['submission'] = $submission;
        return view("User::submission.reupload", $this->data);
    }

    public function reupload(Request $request) {
        $submission = User::find(Auth::id())->submissions()->findOrFail($request->get('id'));
        $validator = $this->submissionValidation($request, $submission->ispublicationonly);
        if($validator->passes()) {
            $uploadedfile = $request->file('file');
            $path = $uploadedfile->store('public/abstract');
            if($submission->ispublicationonly) {
                $submission->update([
                        'title'                         => $request->get('title'),
                        'abstract'                      => $request->get('abstract'),
                        'abstractfile'                  => $path,
                        'publication_id'
                    ]
                );
            } else {
                $submission->update([
                        'title'                         => $request->get('title'),
                        'abstract'                      => $request->get('abstract'),
                        'abstractfile'                  => $path,
                        'submission_type_id'            => $request->get('submission_type_id'),
                    ]
                );
            }


            return response()->json(['success' => true, 'redirect' => route('user.submission')]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }

    public function DTSubmission(Request $request) {
        $user = Auth::user();
        $submission = User::find($user->id)->submissions()
            ->select([
                "id",
                "title",
                "abstract",
                "user_id",
                "workstate_id",
                "abstractfile",
                "submission_event_id",
                "submission_status_id",
                "submission_type_id",
                "approved",
                "file_paper_id",
                "feedback",
                "ispublicationonly"
            ])->where("ispublicationonly", "=", 0)
            ->with(['user','workstate','submission_event','file_paper','submission_type']);

        $datatable = app('datatables')->of($submission)
            ->editColumn('workstate.name', function($s) {
                $sub = Submission::find($s->id);
                return !empty($sub->workstate) ? $sub->workstate->name : "Unavailable" ;
            })
            ->addColumn('file_abstract', function($s) {

                if($s->isPaid()) {
                    $url_upload = "#";
                    $url_reupload = "#";
                    $class = "btn-download disabled";
                    $class_re = "disabled";
                } else {
                    $url_upload = route('user.conference.getabstract', $s->id);
                    $url_reupload = route('user.conference.abstractreupload', $s->id);
                    $class = "";
                    $class_re = "";
                }

                $btn = HtmlHelper::linkButton("Abstract", $url_upload , "btn-xs btn-info {$class}", '',"glyphicon-download");
                $btn .= "<br><br>";
                $btn .= HtmlHelper::linkButton('Reupload', $url_reupload, "btn-xs btn-primary {$class_re}",'target="_blank "', "glyphicon-upload");
                return $btn;
            })
            ->addColumn('action', function($s) {
                if(!empty($s->file_paper)) {
                    $text = "Re-upload";
                } else {
                    $text = "Upload";
                }

                if($s->approved && $s->isPaid()) {
                    $btn = HtmlHelper::linkButton($text, route('user.conference.upload', $s->id), 'btn-xs btn-info btn-modal', "data-id='{$s->id}'", "glyphicon-upload");
                    return $btn;
                } else if($s->approved && !$s->isPaid()) {
                    $msg = "You have not made a payment. Please confirm your payment to unlock upload.";
                    $btn = HtmlHelper::linkButton($text,"#", "btn-xs btn-info btn-disabled","data-toggle='tooltip' title='{$msg}' disabled", 'glyphicon-upload');
                    return $btn . "<br><i>*Not Paid</i>";
                } else {
                    return "Not Yet Approved";
                }
            });

        $datatable->editColumn('submission_event.name', function($s) {
            return $s->submission_event->parent->name . " | " . $s->submission_event->name;
        });

        $datatable->editColumn('feedback', function($s) {
            if ($s->feedback != "") {
                return HtmlHelper::linkButton("Download Feedback", route("user.conference.feedback", $s->id), "btn-xs btn-info","","glyphicon-download");
            } else {
                return "Feedback isn't available";
            }
        });

        $datatable->rawColumns(['file_abstract','action','feedback']);

        return $datatable->make(true);
    }

    public function DTPublication(Request $request) {
        $user = Auth::user();
        $submission = User::find($user->id)->submissions()
            ->select([
                "id",
                "title",
                "abstract",
                "user_id",
                "workstate_id",
                "abstractfile",
                "submission_event_id",
                "submission_status_id",
                "submission_type_id",
                "approved",
                "file_paper_id",
                "feedback",
                "ispublicationonly"
            ])->where("ispublicationonly", "=", 1)
            ->with(['user','workstate','submission_event','file_paper','submission_type']);

        $datatable = app('datatables')->of($submission)
            ->editColumn('workstate.name', function($s) {
                $sub = Submission::find($s->id);
                return !empty($sub->workstate) ? $sub->workstate->name : "Unavailable" ;
            })
            ->addColumn('action', function($s) {
                if(!empty($s->file_paper)) {
                    $text = "Re-upload";
                } else {
                    $text = "Upload";
                }

                if(!$s->isPaid()) {
                    $btn = HtmlHelper::linkButton($text, route('user.conference.upload', $s->id), 'btn-xs btn-info btn-modal', "data-id='{$s->id}'", "glyphicon-upload");
                    return $btn;
                } else {
                    $btn = HtmlHelper::linkButton($text, "#", 'btn-xs btn-info', "disabled", "glyphicon-upload");
                    return $btn;
                }
            });

        $datatable->editColumn('submission_event.name', function($s) {
            return $s->submission_event->parent->name . " | " . $s->submission_event->name;
        });

        $datatable->addColumn('status', function($s) {
           return $s->approved ? "Approved" : "Not Yet Approved";
        });

        $datatable->rawColumns(['file_abstract','action']);

        return $datatable->make(true);
    }

    public function getAbstractFile($id) {
        $sub = User::find(Auth::id())->submissions()->findOrFail($id);
        $ext = AppHelper::getFileExtension($sub->abstractfile);
        $file = public_path(Storage::url($sub->abstractfile));
        return response()->download($file, join(".", [str_replace(' ', '_', $sub->title), $ext]));
    }

    public function publist_get($id) {
        $submission_event = SubmissionEvent::findOrFail($id);
        return response()->json($submission_event->publicationlist());
    }

}