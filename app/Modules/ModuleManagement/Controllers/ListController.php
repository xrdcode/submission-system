<?php

namespace App\Modules\ModuleManagement\Controllers;

use App\Models\BaseModel\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants;
use Yajra\Datatables\Datatables;
use App\Helper\HtmlHelper;

class ListController extends Controller
{

    protected $pagination = 10;

    public function __construct()
    {
        $this->middleware("role:ModuleManagement-View");
    }

    public function index(Request $request) {
        return view("ModuleManagement::index");
    }

    public function DTModule() {
        $modules = Module::select('id','name','pathname','description');
        return Datatables::of($modules)
            ->addColumn('created_by', function($m) {
                $module = Module::find($m->id);
                return !empty($module->createdby) ? $module->createdby->name : "-";
            })
            ->addColumn('updated_by', function($m) {
                $module = Module::find($m->id);
                return !empty($module->updatedby) ? $module->updatedby->name : "-";
            })
            ->addColumn('action', function($m) {
                return HtmlHelper::linkButton("Edit", route('admin.module.edit', $m->id), "btn-xs btn-default btn-edit","", "glyphicon-edit");
            })
            ->make(true);
    }
}
