<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 23/10/2017
 * Time: 17:32
 */

namespace App\Modules\AdminManagement\Controllers\Group;

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
        $this->middleware(['role:GroupManagement-View']);
    }

    public function index(Request $request) {
        return view("AdminManagement::group.index");
    }

    public function DT() {
        $group = Group::query();
        $dt =  Datatables::of($group);

        $dt->addColumn('created_by', function($g) {
            return "";
        });

        $dt->addColumn('updated_by', function($g) {
            return "";
        });

        $dt->addColumn('action', function($g) {
            return HtmlHelper::linkButton("Edit", route('admin.managegroup.edit', $g->id), "btn-xs btn-default btn-edit","", "glyphicon-edit");
        });

        return $dt->make(true);
    }
}