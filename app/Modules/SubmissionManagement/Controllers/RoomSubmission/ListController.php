<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 19/01/2018
 * Time: 10:14
 */

namespace App\Modules\SubmissionManagement\Controllers\RoomSubmission;


use App\Helper\HtmlHelper;
use App\Http\Controllers\Controller;
use App\Models\BaseModel\Room;
use App\Models\BaseModel\RoomSubmission;
use App\Models\BaseModel\Submission;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $rs = RoomSubmission::query()->has("submission")->has("room")->with(["submission","submission.user","submission.submission_event","room"]);
        $dt = Datatables::of($rs);

        $dt->addColumn("room_detail", function($q) {
            $text = "<table>";
            $text .= "<tr><td>Name </td><td style='padding-left: 10px;padding-right: 10px'> : </td><td> {$q->room->name} </td></tr>";
            $text .= "<tr><td>Building </td><td style='padding-left: 10px;padding-right: 10px'> : </td><td> {$q->room->building} </td></tr>";
            $text .= "<tr><td>Location </td><td style='padding-left: 10px;padding-right: 10px'> : </td><td> {$q->room->address} </td></tr>";
            $text .= "<tr><td>Notes </td><td style='padding-left: 10px;padding-right: 10px'> : </td><td> {$q->room->notes} </td></tr>";
            $text .= "</table>";
            return $text;
        });

        $dt->addColumn('action', function ($q) {
            return HtmlHelper::linkButton(' Edit', route('admin.submission.room.edit', $q->id), 'btn-xs btn-default btn-edit',"" ,'glyphicon-edit');
        });

        $dt->editColumn("datetimes", function($q) {
            $d = Carbon::createFromFormat("Y-m-d H:i:s", $q->datetimes);

            $date = $d->format("D, jS M Y");
            return $date;
        });

        $dt->editColumn("times", function($q) {
            $d = Carbon::createFromFormat("Y-m-d H:i:s", $q->datetimes);

            $date =  $d->format("H.i") . " WIB";

            return $date;
        });

        $dt->rawColumns(["room_detail","datetimes","action"]);

        return $dt->make(true);
    }

    public function submission_list(Request $request) {
        $s = Submission::query()
            ->where("ispublicationonly","=", 0)
            ->where("submission_type_id","=",1)
            ->doesnthave("room_submission")->with(["user"]);

        $selectlist = array();

        foreach ($s->get() as $k) {
            $selectlist[$k->id] = "{$k->title} - {$k->user->name}";
        }

        return response()->json($selectlist);
    }

    public function room_list() {
        $r = Room::query()->get();
        $room = array();

        foreach ($r as $v) {
            $room[$v->id] = "{$v->building} - {$v->name}";
        }

        return response()->json($room);
    }
}