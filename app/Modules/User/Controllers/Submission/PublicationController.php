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

class PublicationController extends Controller
{

    public function register() {
        $this->data['header'] = "Register Publication";
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
                    'ispublicationonly' => true //Conference Participant
                ]
            );

            return response()->json(['success' => true, 'redirect' => route('user.conference.list')]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }

    public function submissionValidation(Request $request) {
        return Validator::make($request->all(), [
            'title'                 => 'required|string|max:255|',
            'abstract'              => 'required|string',
            'file'                  => 'required|file|mimes:pdf,doc,docx|max:2048',
            'submission_event_id'   => 'required|numeric',
            'submission_type_id'    => 'required|numeric',
        ]);
    }


}