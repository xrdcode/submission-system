<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 19/01/2018
 * Time: 10:04
 */

namespace App\Modules\MasterdataManagement\Controllers\Room;


use App\Http\Controllers\Controller;
use App\Models\BaseModel\Rooms;
use Yajra\Datatables\Datatables;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:RoomManagement-View']);
    }

    public function index() {
        return view("MasterdataManagement::room.index");
    }

    public function DT() {
        $room = Rooms::query();
        $dt = Datatables::of($room);

        return $dt->make(true);
    }
}