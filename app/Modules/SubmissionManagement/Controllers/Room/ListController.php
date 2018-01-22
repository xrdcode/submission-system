<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 19/01/2018
 * Time: 10:04
 */

namespace App\Modules\SubmissionManagement\Controllers\Room;


use App\Http\Controllers\Controller;
use App\Models\BaseModel\Rooms;
use Yajra\Datatables\Datatables;

class ListController extends Controller
{
    public function index() {

    }

    public function DT() {
        $room = Rooms::query();
        $dt = Datatables::of($room);

        return $dt->make(true);
    }
}