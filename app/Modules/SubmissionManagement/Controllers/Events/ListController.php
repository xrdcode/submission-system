<?php
namespace App\Modules\SubmissionManagement\Controllers\Events;
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
        return view("SubmissionManagement::events.index");
    }

    public function DTEvents() {
        $event = SubmissionEvent::select(['id','name','parent_id','description','valid_from','valid_thru']);
        return Datatables::of($event)
            ->addColumn('action', function ($user) {
                return HtmlHelper::linkButton(' Edit', route('admin.event.edit', $user->id), 'btn-xs btn-default btn-edit', 'glyphicon-edit');
            })
            ->addColumn('date_range', function($event) {
                $from = Carbon::createFromFormat('Y-m-d H:i:s', $event->valid_from);
                $thru= Carbon::createFromFormat('Y-m-d H:i:s', $event->valid_thru);
                return $from->format("d F Y") . " - " . $thru->format("d F Y");
            })
            ->addColumn('created_by', function($event) {
                $ev = SubmissionEvent::find($event->id);
                return empty($ev->createdby) ? "-" : $ev->createdby->name ;
            })
            ->addColumn('updated_by', function($event) {
                $ev = SubmissionEvent::find($event->id);
                return empty($ev->updatedby) ? "-" : $ev->updatedby->name ;
            })
            ->addColumn('parent', function($event) {
                $ev = SubmissionEvent::find($event->id);
                return empty($ev->parent) ? "-" : $ev->parent->name ;
            })
            ->make(true);
    }
}
