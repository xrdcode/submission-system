<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 10:49
 */

namespace App\Modules\User\Controllers\Submission;

use App\Helper\Constant;
use App\Http\Controllers\Controller;
use App\Models\BaseModel\FilePaper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

class PapersController extends Controller
{
    protected $nextstate = 4; //LOOK AT MASTERDATA

    public function index(Request $request, $id) {
        $data = [
          'action'  => route('user.conference.doupload', $id),
          's'       => Auth::user()->submissions()->findOrFail($id)
        ];
        return view('User::paper.upload', $data);
    }

    public function upload(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'submission_id' => 'required|numeric|',
            'file'  => 'required|file|mimes:doc,docx|max:20480'
        ]);

        if($validator->passes()) {
            $submission = Auth::user()->submissions->find($id);
            $uploadedfile = $request->file('file');
            if(empty($submission->file_paper)) {
                $path = $uploadedfile->store('public/full_paper');
                $fp = new FilePaper();
                $data = [
                  'name'            => $uploadedfile->getClientOriginalName(),
                  'type'            => $uploadedfile->getMimeType(),
                  'path'            => $path
                ];
                $fp = $fp->create($data);
                $submission->file_paper()->associate($fp);
                $submission->workstate_id = Constant::AFTER_UPLOAD_PAPER;
                $submission->update();
            } else {
                $old = $submission->file_paper->path;
                $path = $uploadedfile->store('public/full_paper');
                $data = [
                    'name'            => $uploadedfile->getClientOriginalName(),
                    'type'            => $uploadedfile->getMimeType(),
                    'path'            => $path
                ];
                $submission->file_paper()->update($data);
                if(!empty($old))
                    unlink(public_path(Storage::url($old)));
            }

            return response()->json(['success' => true]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }

    public function getFeedback($id) {
        $submission = Auth::user()->submissions->find($id);
        $body = $submission->feedback;

        $name = $submission->title . "_feedback.txt";

        $headers = [
            'Content-type'        => 'plain/txt',
            'Content-Disposition' => "attachment; filename=\"{$name}\"",
        ];

        return response()->make($body, 200, $headers);
    }
}