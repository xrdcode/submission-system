<?php

namespace App\Modules\ModuleManagement\Controllers;

use App\Models\BaseModel\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants;

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
}
