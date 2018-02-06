<?php
/**
 * Created by PhpStorm.
 * User: reysd
 * Date: 05/02/2018
 * Time: 11.55
 */

namespace App\Modules\User\Controllers\Workshop;


use App\Helper\Constant;
use App\Helper\HtmlHelper;
use App\Http\Controllers\Controller;
use App\Models\BaseModel\GeneralPayment;
use App\Models\BaseModel\SubmissionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Yajra\Datatables\Datatables;

class MainController extends Controller
{
    public function index() {
        $this->data['header'] = "Workshop List";
        return view("User::workshop.index", $this->data);
    }

    public function register() {
        $this->data['header'] = "Register Workshop";
        $eventlist = SubmissionEvent::getlist(false);
        $this->data['eventlist'] = $eventlist;
        return view('User::workshop.register', $this->data);
    }

    public function _ModalEdit($id) {
        if(!\Request::ajax())
            return ":p";
        $this->data['header'] = "Edit Workshop";
        $this->data['class'] = "modal-sm";
        $this->data['gp']       = Auth::user()->general_payments()->findOrFail($id);
        return view("User::workshop.medit", $this->data);
    }

    public function _ModalConfirm($id) {
        if(!\Request::ajax())
            return ":p";
        $this->data['header'] = "Upload Transfer Receipt";
        $this->data['class'] = "modal-sm";
        $this->data['gp']       = Auth::user()->general_payments()->findOrFail($id);
        $this->data['action']       = route('user.workshop.upload', $id);
        return view("User::workshop.mconfirm", $this->data);
    }

    public function validator(Request $request) {
        return Validator::make($request->all(), [
            'submission_event_id'       => 'required|numeric|unique:general_payments',
            'pricing_id'                => 'required|numeric'
        ],[
            'submission_event_id.unique' => 'You only join the workshop once, if you wanna change the title please edit in workshop list'
        ]);
    }

    public function store(Request $request) {
        $validator = $this->validator($request);
        if($validator->passes()) {
            $workshop = new GeneralPayment();
            $request['workstate_id'] = Constant::WS_TRX_CONFIRM;
            $request['user_id'] = Auth::id();
            $workshop->create($request->all());
            return response()->json(['success' => true, 'redirect' => route('user.workshop')]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }

    public function update(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'submission_event_id'       => 'required|numeric',
            'pricing_id'                => 'required|numeric',
        ]);

        if($validator->passes()) {
            $workshop = GeneralPayment::findOrFail($id);
            if(!empty($workshop->file))
                return response()->json(['success' => true]);
            $request['workstate_id'] = Constant::WS_TRX_CONFIRM;
            $workshop->update($request->only(['pricing_id']));
            return response()->json(['success' => true, 'redirect' => route('user.dashboards')]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }

    public function upload(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'submission_event_id'       => 'required|numeric',
            'file'                      => 'required|file|mimes:jpg,png'
        ]);
        if($validator->passes()) {
            $uploadedfile = $request->file('file');
            $path = $uploadedfile->store('public/workshop');
            $workshop = GeneralPayment::findOrFail($id);
            $old = $workshop->file;
            $workshop->file = $path;
            $workshop->workstate_id = Constant::WS_TRX_VERIFY;
            $workshop->update();
            if(!empty($old))
                unlink(public_path(Storage::url($old)));
            return response()->json(['success' => true, 'redirect' => route('user.workshop')]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }

    public function DT() {
        $gp = Auth::user()->general_payments()->with(['submission_event','pricing','pricing.pricing_type','workstate']);
        $dt = Datatables::of($gp);

        $dt->editColumn('pricing.price', function($gp) {
            if(Auth::user()->personal_data->islocal)
                return "IDR {$gp->pricing->price}";
            return "USD {$gp->pricing->usd_price}";
        });

        $dt->addColumn('action', function($gp) {
            $btn = "";
            if(!$gp->isPaid()) {
                if(empty($gp->file)) {
                    $btn .= HtmlHelper::linkButton("Edit",route('user.workshop.edit', $gp->id),'btn-xs btn-info btn-edit','' , 'glyphicon-edit');
                    $btn .= "<div style='height: 5px'></div>";
                    $btn .= HtmlHelper::linkButton('Upload Receipt', route('user.workshop.confirm', $gp->id),'btn-xs btn-warning btn-modal','', 'glyphicon-upload');
                } else {
                    $btn .= HtmlHelper::linkButton('Re-upload Receipt', route('user.workshop.confirm', $gp->id),'btn-xs btn-warning btn-modal','', 'glyphicon-upload');
                }
            } else {
                return HtmlHelper::linkButton('Ticket',route('user.workshop.ticket', $gp->id), 'btn-xs btn-success btn-modal','','glyphicon-eye-open');
            }

            return $btn;
        });


        $dt->rawColumns(['action']);

        return $dt->make(true);
    }


    ///
    /// API
    ///

    public function ws_list($id) {
        $event = SubmissionEvent::find($id);
        return response()->json($event->workshoplist());

    }


    /// MODAL
    ///

    public function _ticket($id) {
        if(!\Request::ajax())
            return "Hehe :p";

        $gp = GeneralPayment::findOrFail($id);

        if(empty($gp->workshop_ticket))
            abort(404);
        $this->data['ticket'] = $gp->workshop_ticket;
        $this->data['gp'] = $gp;
        return view("User::workshop.ticket", $this->data);
    }



}