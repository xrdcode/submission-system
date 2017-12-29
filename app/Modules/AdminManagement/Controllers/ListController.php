<?php

namespace App\Modules\AdminManagement\Controllers;

use App\Modules\AdminManagement\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants;

class ListController extends Controller
{

    protected $pagination = 10;

    public function __construct()
    {
        $this->middleware("role:AdminManagement-View");
    }

    public function index(Request $request) {
        if($request->search) {
            $admins = Admin::search($request->search)->paginate($this->pagination);
        } else {
            $admins = Admin::orderBy('name',  'asc')->paginate($this->pagination);
        }

        return view("AdminManagement::index", ["admins" => $admins, 'search' => $request->search] );
    }

    public function search(Request $request) {

    }
}
