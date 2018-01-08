<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 07/01/2018
 * Time: 13:53
 */

namespace App\Modules\SubmissionManagement\Controllers\Schedules;



use App\Models\BaseModel\Pricing;
use App\Http\Controllers\Controller;
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
                return HtmlHelper::linkButton("Edit",route('admin.pricing.edit', $p->id),"btn-xs btn-info btn-edit","", "glyphicon-edit");
            })
            ->make(true);
    }
}