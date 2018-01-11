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
use App\Models\BaseModel\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

class PapersController extends Controller
{
    protected $nextstate = 4; //LOOK AT MASTERDATA

    public function index(Request $request, $id) {
        $data = [
          'action'  => route('user.submission.doupload', $id),
          's'       => Auth::user()->submissions()->findOrFail($id)
        ];
        return view('User::paper.upload', $data);
    }

    public function upload(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'submission_id' => 'required|numeric|',
            'file'  => 'required|file|mimes:doc,docx|max:500'
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
                $fp->create($data);
                $submission->file_paper()->associate($fp)->update();
                $submission->workstate_id = Constant::AFTER_UPLOAD_PAPER;
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
}