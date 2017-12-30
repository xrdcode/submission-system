<?php

namespace App\Modules\ModuleManagement\Controllers;

use App\Models\BaseModel\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants;
use Yajra\Datatables\Datatables;

class ListController extends Controller
{

    protected $pagination = 10;

    public function __construct()
    {
        $this->middleware("role:ModuleManagement-View");
    }

    public function index(Request $request) {
        if($request->search) {
            $modules = Module::search($request->search)->paginate($this->pagination);
        } else {
            $modules = Module::orderBy('name',  'asc')->paginate($this->pagination);
        }

        return view("ModuleManagement::index", ["modules" => $modules, 'search' => $request->search] );
    }

    public function search(Request $request) {

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
            ->make(true);
    }
}
