<?php

namespace App\Modules\MasterdataManagement\Controllers\Workstate;

use App\Models\BaseModel\Workstate;
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
        $this->middleware("role:MasterdataManagement-View");
    }

    public function index(Request $request) {
        return view("MasterdataManagement::Workstate.index");
    }

    public function DTWorkstate() {
        $ws = Workstate::select('id','name','description');
        return Datatables::of($ws)
            ->addColumn('created_by', function($m) {
                $ws = Workstate::find($m->id);
                return !empty($ws->createdby) ? $ws->createdby->name : "-";
            })
            ->addColumn('updated_by', function($m) {
                $ws = Workstate::find($m->id);
                return !empty($ws->updatedby) ? $ws->updatedby->name : "-";
            })
            ->addColumn('action', function($m) {
                return HtmlHelper::linkButton("Edit", route('admin.master.workstate.edit', $m->id), "btn-xs btn-default btn-edit","", "glyphicon-edit");
            })
            ->make(true);
    }
}
