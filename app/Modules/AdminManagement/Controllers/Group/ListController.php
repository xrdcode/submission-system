<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 23/10/2017
 * Time: 17:32
 */

namespace App\Modules\AdminManagement\Controllers\Group;

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
        $this->middleware(['role:GroupManagement-View']);
    }

    public function index(Request $request) {
        if($request->search) {
            $groups = Group::search($request->search)->paginate($this->pagination);
        } else {
            $groups = Group::orderBy('name',  'asc')->paginate($this->pagination);
        }
        $rolelist = Role::GetSelectableList();
        return view("AdminManagement::group.index", ["groups" => $groups, 'search' => $request->search] );
    }

    public function search(Request $request) {

    }
}