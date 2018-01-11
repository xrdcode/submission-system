<?php

namespace App\Modules\AdminManagement\Controllers;

use App\Helper\HtmlHelper;
use App\Modules\AdminManagement\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants;
use Yajra\Datatables\Datatables;

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

    public function DT() {
        $admin = Admin::query();
        $dt =  Datatables::of($admin);

        $dt->addColumn('groups', function($s) {
            $html = "";
            foreach ($s->groups as $g) {
                $html .= HtmlHelper::createTag('label',['label','label-info'],[], $g->name);
            }
           return $html;
        });

        $dt->addColumn('status', function($s) {
            if($s->active) {
               return HtmlHelper::createTag('label',['label','label-success'],[], "Active");
            } else {
                return HtmlHelper::createTag('label',['label','label-danger'],[], "Disabled");
            }
        });

        $dt->addColumn('created_by', function($a) {
            return "";
        })->addColumn('updated_by', function($a) {
            return "";
        });

        $dt->addColumn('action', function($m) {
            return HtmlHelper::linkButton("Edit", route('admin.manageadmin.edit', $m->id), "btn-xs btn-default btn-edit","", "glyphicon-edit");
        })->rawColumns(['groups','action','status']);

        return $dt->make(true);
    }


}
