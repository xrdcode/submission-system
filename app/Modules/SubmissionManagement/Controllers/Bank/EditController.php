<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\SubmissionManagement\Controllers\Bank;


use App\Helper\Constant;
use App\Http\Controllers\Controller;

use App\Models\BaseModel\BankEvent;
use App\Models\BaseModel\Submission;
use App\Models\BaseModel\SubmissionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:EventManagement-Create'])->only(['store','newevent']);
        $this->middleware(['role:EventManagement-Save'])->only(['update','index','activate']);
    }

    public function index($id) {
        $events = SubmissionEvent::findOrFail($id);
        $data = [
            'action'        => route('admin.event.update', $id),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'eventmodal',
            'title'         => 'Edit Bank Account',
            'parentlist'    => SubmissionEvent::parentlist(),
            'ev'        => $events
        ];
        return view("SubmissionManagement::bank.medit", $data);
    }


    public function newevent($id) {
        $data = [
            'action'        => route('admin.bank.store', $id),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'eventmodal',
            'title'         => 'Add New Bank Account',
            'submission_event_id'     => $id
        ];
        return view("SubmissionManagement::bank.new", $data);
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $event = BankEvent::find($id);
            $event->updated_by = Auth::user()->id;
            $request['bank'] = Constant::BANK_LIST[$request->get('bank')];
            $event->update($request->all());
            return response()->json([$event]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    protected function validator(Request $request, $submission_event_id = null) {
        if(!empty($submission_event_id))
            $request['submission_event_id'] = $submission_event_id;
        return Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'number' => "required|numeric|unique:bank_events,number,{$request->id}",
            'bank' => 'required|string|max:200',
            'submission_event_id' => 'required|numeric'
        ]);
    }

    public function store(Request $request, $id) {
        $validator = $this->validator($request, $id);
        if($validator->passes()) {
            $bank = new BankEvent();
            $request['submission_event_id'] = $id;
            $request['bank'] = Constant::BANK_LIST[$request->get('bank')];
            $bank->create($request->all());
            return response()->json(["success" => true]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


}