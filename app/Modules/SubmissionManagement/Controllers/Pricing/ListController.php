<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 07/01/2018
 * Time: 13:53
 */

namespace App\Modules\SubmissionManagement\Controllers\Pricing;



use App\Models\BaseModel\Pricing;
use App\Http\Controllers\Controller;
use App\Modules\SubmissionManagement\Models\PricingType;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\Helper\HtmlHelper;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:PricingManagement-View']);
    }
    
    public function index() {
        return view("SubmissionManagement::Pricing.index");
    }



    public function DTPricing() {
        $pricing = Pricing::select(["id","price", "submission_event_id", "pricing_type_id", "created_by", "updated_by"])->with(['submission_event','pricing_type','createdby', 'updatedby']);
        return Datatables::of($pricing)
            ->addColumn('action', function($p) {
                $btn = HtmlHelper::linkButton("Edit",route('admin.pricing.edit', $p->id),"btn-xs btn-info btn-edit","", "glyphicon-edit");
                $btn .= HtmlHelper::linkButton("Delete", route('admin.pricing.delete', $p->id), "btn-xs btn-danger btn-delete", "", "glyphicon-trash");
                return "<div class='btn-group'>{$btn}</div>";
            })
            ->make(true);
    }

    ///// PTICING TYPES ///////

    public function type() {
        return view("SubmissionManagement::pricing.types");
    }

    public function DTPtype() {
        $pt = PricingType::query()->with(['createdby', 'updatedby']);
        $dt = Datatables::of($pt);

        $dt->editColumn('createdby.name', function($p) {
           if(empty($p->createdby)) {
               return "-";
           } else {
               return $p->createdby->name;
           }
        });

        $dt->editColumn('updatedby.name', function($p) {
            if(empty($p->updatedby)) {
                return "-";
            } else {
                return $p->updatedby->name;
            }
        });

        $dt->addColumn('action', function($p) {
            $btn = HtmlHelper::linkButton("Edit",route('admin.pricing.type.edit', $p->id),"btn-xs btn-info btn-edit","", "glyphicon-edit");
            $btn .= HtmlHelper::linkButton("Delete", route('admin.pricing.type.delete', $p->id), "btn-xs btn-danger btn-delete", "", "glyphicon-trash");
            return "<div class='btn-group'>{$btn}</div>";
        });

        $dt->rawColumns(['createdby','action']);

        return $dt->make(true);
    }
}