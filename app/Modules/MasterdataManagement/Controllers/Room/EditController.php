<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 23/01/2018
 * Time: 17:01
 */

namespace App\Modules\MasterdataManagement\Controllers\Room;


use App\Http\Controllers\Controller;
use App\Models\BaseModel\Room;
use Illuminate\Http\Request;
use Validator;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:RoomManagement-Create'])->only(['store','newroom']);
        $this->middleware(['role:RoomManagement-Save'])->only(['update','index','delete']);
    }

    public function index($id) {
        $data = [
            'action'    => route('admin.master.room.update', $id),
            'room'      => Room::findOrFail($id),
            'title'     => "Edit Room"
        ];
        return view("MasterdataManagement::room.medit", $data);
    }

    public function newroom() {
        $data = [
            'action' => route('admin.master.room.store'),
            'title'     => "Add New Room"
        ];
        return view("MasterdataManagement::room.new", $data);
    }

    public function validates(Request $request) {
        return Validator::make($request->all(),
        [
            'name'  => 'required|string',
            'number'  => 'required|string',
            'building'  => 'required|string|max:150',
            'notes'  => 'required|string|max:150',
            'address'  => 'required|string|max:150',
        ]
        );


    }

    public function store(Request $request) {
        $validate = $this->validates($request);
        if($validate->passes()) {
            Room::create($request->all());
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'errors' => $validate->getMessageBag()->toArray()]);
        }
    }

    public function update(Request $request, $id) {
        $validate = $this->validates($request);
        if($validate->passes()) {
            $room = Room::findOrFail($id);
            $room->update($request->only('name','number','building','notes', 'address'));
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'errors' => $validate->getMessageBag()->toArray()]);
        }
    }

    public function delete(Request $request, $id) {

    }
}