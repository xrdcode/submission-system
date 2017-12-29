<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 23/10/2017
 * Time: 17:32
 */

namespace App\Modules\AdminManagement\Controllers\Role;

use App\Modules\AdminManagement\Models\Admin;
use App\Modules\AdminManagement\Models\Group;
use App\Modules\AdminManagement\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants;

class ListController extends Controller
{
    protected $pagination = 10;

    public function __construct()
    {
        $this->middleware(['role:RoleManagement-View']);
    }

    public function index(Request $request) {
        if($request->search) {
            $roles = Role::search($request->search)->paginate($this->pagination);
        } else {
            $roles = Role::orderBy('name',  'asc')->paginate($this->pagination);
        }

        return view("AdminManagement::role.index", ["roles" => $roles] );
    }

    public function search(Request $request) {

    }

    public function refreshTable() {
        if(Request::ajax()) {
            $roles = Role::orderBy('name',  'asc')->paginate($this->pagination);
            return view("AdminManagement::role.index", ["roles" => $roles])->renderSections()["content"];
        }

        return 0;
    }
}