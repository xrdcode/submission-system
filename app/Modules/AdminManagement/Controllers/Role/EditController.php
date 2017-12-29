<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 23/10/2017
 * Time: 17:33
 */


namespace App\Modules\AdminManagement\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Modules\AdminManagement\Models\Group;
use App\Modules\AdminManagement\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:RoleManagement-Create'])->only(['store','newrole']);
        $this->middleware(['role:RoleManagement-Save'])->only(['update','index']);
    }

    public function index($id) {
        $role = Role::find($id);
        return view("AdminManagement::role.edit", ["role" => $role]);
    }

    public function newrole() {
        $data = [
            'action' => route('admin.managerole.store'),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'   => 'rolemodal',
            'title'     => 'New Role'
        ];
        return view("AdminManagement::role.new", $data );
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $role = Role::find($id);
            $role->update($request->all());
            return response()->json([$role]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function validator(Request $request) {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $request->id,
            'description' => 'required|string|max:255',
        ]);
    }

    public function store(Request $request) {
        $validator = $this->validator($request);
        $admin = Auth::user();
        if($validator->passes()) {
            $role = new Role();
            $role = $role->create($request->only(['name','description']));
            $role->created_by = $admin->id;
            $role->updated_by = $admin->id;
            $role->update();
            return response()->json([$role]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }
}