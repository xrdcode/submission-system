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
use Yajra\Datatables\Datatables;

class ListController extends Controller
{
    public function index() {
        return view("SubmissionManagement::roomsubmission");
    }

    public function DT() {
        $rs = RoomSubmission::query();
        $dt = Datatables::of($rs);

        return $dt->make(true);
    }
}