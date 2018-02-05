<?php
namespace App\Modules\SubmissionManagement\Controllers\Bank;
use App\Models\BaseModel\BankEvent;
use App\Models\BaseModel\SubmissionEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\Helper\HtmlHelper;

class ListController extends Controller
{

    protected $pagination = 10;

    public function __construct()
    {
        //$this->middleware("role:EventsManagement-View");
    }

    public function index() {
        return view("SubmissionManagement::bank.index");
    }

    public function DTEvents() {
        $event = SubmissionEvent::whereNull('parent_id');
        return Datatables::of($event)
            ->addColumn('action', function ($e) {
                $btn = HtmlHelper::linkButton('Add Bank', route('admin.bank.new', $e->id), 'btn-xs btn-default btn-edit',"" ,'glyphicon-plus');
                return $btn;
            })

            ->addColumn('banks', function($s) {
                $html = "";
                foreach ($s->banks as $b) {
                    $html .= "{$b->number} {$b->bank} p.p. {$b->name} </br>";
                }
                return $html;
            })

            ->addColumn('created_by', function($event) {
                $ev = SubmissionEvent::find($event->id);
                return empty($ev->createdby) ? "-" : $ev->createdby->name ;
            })
            ->addColumn('updated_by', function($event) {
                $ev = SubmissionEvent::find($event->id);
                return empty($ev->updatedby) ? "-" : $ev->updatedby->name ;
            })

            ->rawColumns(['action','banks'])
            ->make(true);
    }
}
