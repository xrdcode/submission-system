<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 19/01/2018
 * Time: 10:14
 */

namespace App\Modules\SubmissionManagement\Controllers\RoomSubmission;


use App\Http\Controllers\Controller;
use App\Models\BaseModel\RoomSubmission;
use App\Models\BaseModel\Submission;
use Yajra\Datatables\Datatables;

class ListController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:RoomManagement-View']);
    }

    public function index() {
        return view("SubmissionManagement::roomsubmission.index");
    }

    public function DT() {
        $rs = Submission::query()->with(["room_submission", "submission_type", "workstate", "submission_event", "user"]);
        $dt = Datatables::of($rs);

        return $dt->make(true);
    }
}