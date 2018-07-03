<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 15/02/18
 * Time: 23:31
 */

namespace App\Modules\SubmissionManagement\Controllers\RoomSubmission;


use App\Http\Controllers\Controller;
use App\Models\BaseModel\RoomSubmission;
use Illuminate\Http\Request;
use Validator;

class EditController extends Controller
{
    public function index() {

    }

    public function maproom() {
        $data = array(
            'action' => route('admin.submission.room.store'),
            'modalId'       => 'eventmodal',
            'title'         => 'Assign Room',
        );
        return view("SubmissionManagement::roomsubmission.massign", $data);
    }

    protected function validator(Request $request) {
        return Validator::make($request->all(), [
            'submission_id' => 'required|numeric',
            'room_id'       => 'required|numeric',
            'datetimes'     => 'required|date_format:Y-m-d',
            'hours'         => 'required|string|numeric',
            'minutes'         => 'required|string|numeric',

        ]);
    }

    public function store(Request $request) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $rs = new RoomSubmission();
            $data = $request->only(["datetimes",'submission_id','room_id']);
            $data['datetimes'] .= " {$request->get('hours')}:{$request->get('minutes')}:00";

            $rs = $rs->create($data);
            return response()->json($data);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }
}