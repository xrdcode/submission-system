<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 23/10/2017
 * Time: 17:32
 */

namespace App\Modules\AdminManagement\Controllers\Role;

use App\Helper\HtmlHelper;
use App\Modules\AdminManagement\Models\Admin;
use App\Modules\AdminManagement\Models\Group;
use App\Modules\AdminManagement\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants;
use Yajra\Datatables\Datatables;

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

    public function DT() {
        $role = Role::query();
        $dt =  Datatables::of($role);

        $dt->addColumn('created_by', function($a) {
            return "";
        });

        $dt->addColumn('updated_by', function($a) {
            return "";
        });

        $dt->addColumn('action', function($m) {
            return HtmlHelper::linkButton("Edit", route('admin.managerole.edit', $m->id), "btn-xs btn-default btn-edit","", "glyphicon-edit");
        });

        return $dt->make(true);
    }
}