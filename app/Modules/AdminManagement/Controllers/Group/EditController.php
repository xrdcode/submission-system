<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 23/10/2017
 * Time: 17:33
 */


namespace App\Modules\AdminManagement\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Modules\AdminManagement\Models\Group;
use App\Modules\AdminManagement\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:GroupManagement-Create'])->only(['store','newgroup']);
        $this->middleware(['role:GroupManagement-Save'])->only(['update','index']);
    }

    public function index($id) {
        $group = Group::find($id);
        $rolelist = Role::GetSelectableList();
        return view("AdminManagement::group.medit", ["group" => $group, "rolelist" => $rolelist]);
    }

    public function newgroup() {
        $data = [
            'action' => route('admin.managegroup.store'),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'   => 'groupmodal',
            'title'     => 'New Group',
            'rolelist' => Role::GetSelectableList()

        ];
        return view("AdminManagement::group.new", $data );
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);
        $admin = Auth::user();
        if($validator->passes()) {
            $group = Group::find($id);
            $group->update($request->all());
            $group->saveRole($request->rolelist);
            $group->updated_by = $admin->id;
            $group->update();
            return response()->json([$group, $request->rolelist]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function validator(Request $request) {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:groups,name,' . $request->id,
            'description' => 'required|string|max:255',
        ]);
    }

    public function store(Request $request) {
        $validator = $this->validator($request);
        $admin = Auth::user();
        if($validator->passes()) {
            $group = new Group();
            $group = $group->create($request->only(['name','description']));
            $group->created_by = $admin->id;
            $group->updated_by = $admin->id;
            $group->saveRole($request->rolelist);
            $group->update();
            return response()->json([$group]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }
}