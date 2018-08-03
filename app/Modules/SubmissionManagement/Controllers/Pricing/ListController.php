<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 07/01/2018
 * Time: 13:53
 */

namespace App\Modules\SubmissionManagement\Controllers\Pricing;



use App\Helper\AppHelper;
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
        return view("SubmissionManagement::pricing.index");
    }



    public function DTPricing() {
        $pricing = Pricing::select(["id","price","title","occupation", "submission_event_id", "pricing_type_id","early_price","isparticipant", "created_by", "updated_by"])->with(['submission_event','pricing_type','createdby', 'updatedby']);
        $dt = Datatables::of($pricing);
        $dt->addColumn('action', function($p) {
            $btn = HtmlHelper::linkButton("Edit",route('admin.pricing.edit', $p->id),"btn-xs btn-info btn-edit","", "glyphicon-edit");
            $btn .= HtmlHelper::linkButton("Delete", route('admin.pricing.delete', $p->id), "btn-xs btn-danger btn-delete", "", "glyphicon-trash");
            return "<div class='btn-group'>{$btn}</div>";
        });

        $dt->editColumn("submission_event.name", function($p) {
            return "<strong>{$p->submission_event->parent->name}</strong> | {$p->submission_event->name}";
        });

        $dt->editColumn('price', function($p) {
            $early =  !empty($p->early_price) ? AppHelper::formatCurrency($p->early_price, ".") : 0;
            $price = AppHelper::formatCurrency($p->price,".");
           return "Rp. {$early} - Early <br/> Rp. {$price} - Normal";
        });

        $dt->editColumn('isparticipant', function($p) {
           return $p->isparticipant ? "Participant" : "Non-Participant";
        });

        $dt->rawColumns(["name", "action","price"]);
        return $dt->make(true);
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