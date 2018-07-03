<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 19/01/2018
 * Time: 10:04
 */

namespace App\Modules\MasterdataManagement\Controllers\Room;


use App\Helper\HtmlHelper;
use App\Http\Controllers\Controller;
use App\Models\BaseModel\Room;
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
        $room = Room::query();
        $dt = Datatables::of($room);

        $dt->addColumn('action', function ($r) {
           return HtmlHelper::linkButton('Edit', route('admin.master.room.edit', $r->id), 'btn-xs btn-default btn-edit','','glyphicon-edit');
        });

        return $dt->make(true);
    }
}