<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\SubmissionManagement\Controllers\Pricing;


use App\Http\Controllers\Controller;

use App\Models\BaseModel\PricingType;
use App\Modules\SubmissionManagement\Models\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:PricingManagement-Create'])->only(['store','newprice']);
        $this->middleware(['role:PricingManagement-Save'])->only(['update','index','activate']);
    }

    public function index($id) {
        $pricings = Pricing::findOrFail($id);
        $data = [
            'action'        => route('admin.pricing.update', $id),
            'modalId'       => 'pricingmodal',
            'title'         => 'Edit Pricing',
            'pricing'       => $pricings
        ];
        return view("SubmissionManagement::pricing.medit", $data);
    }


    public function newprice() {
        $data = [
            'action'        => route('admin.pricing.store'),
            'modalId'       => 'pricingmodel',
            'title'         => 'Create New Price',
            'eventlist'    => Pricing::getEventList(),
            'typelist'    => PricingType::getList()
        ];
        return view("SubmissionManagement::pricing.new", $data);
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $pricing = Pricing::find($id);

            $pricing->updated_by = Auth::user()->id;

            $pricing->update($request->only(['price','submission_event_id','pricing_types']));
            return response()->json([$pricing]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function activate($id) {
        $module = Module::find($id);
        $module->active = true;
        return response()->json($module->saveOrFail());
    }

    protected function validator(Request $request) {
        return Validator::make($request->all(), [
            'submission_event_id' => [
                'required',
                'numeric',
                'max:255'
            ],
            'pricing_type_id' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
    }

    public function store(Request $request) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $find = Pricing::where('submission_event_id','=', $request->get('submission_event_id'))
                ->where('pricing_type_id','=',$request->get('pricing_type_id'))->first();
            if(!empty($find)) {
                $pricing = $find;
                $pricing->update($request->all());
            } else {
                $pricing = new Pricing();
                $pricing = $pricing->create($request->all());
                $pricing->created_by = Auth::user()->id;
                $pricing->updated_by = Auth::user()->id;
                $pricing->update();
            }
            return response()->json([$pricing]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function delete(Request $request,$id) {
        $pricing = Pricing::findOrFail($id);
        if($pricing->payment_submissions->count() == 0) {
            $res = $pricing->delete();
            $message = "Delete Success";
        } else {
            $res = false;
            $message = "This pricing already used, cannot delete.";
        }
        return response()->json(['success' => $res, 'message' => $message, 'data' => $pricing]);
    }

    ///// PTICING TYPES ///////

    public function new_type() {
        $data = [
            'action'        => route('admin.pricing.type.store'),
            'title'         => 'Create New Pricing Type',
        ];
        return view("SubmissionManagement::pricing.newtype", $data);
    }

    public function edit_type($id) {
        $data = [
            'action'        => route('admin.pricing.type.update', $id),
            'title'         => 'Create Edit Pricing Type',
            'type'          => PricingType::findOrFail($id)
        ];
        return view("SubmissionManagement::pricing.mtypes", $data);
    }

    public function store_type(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
            'description'  => 'required|string',
        ]);

        if($validator->passes()) {
            $pt = new PricingType();
            $pt = $pt->create($request->only(['name','description']));
            $pt->created_by = Auth::user()->id;
            $pt->updated_by = Auth::user()->id;
            $pt->active = true;
            $pt->update();
            return response()->json(['success'=> true]);
        } else {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }
    }

    public function delete_type(Request $request,$id) {
        $pt = PricingType::findOrFail($id);
        if($pt->pricings->count() == 0) {
            $res = $pt->delete();
            $message = "Delete Success";
        } else {
            $res = false;
            $message = "This data already used, cannot delete.";
        }
        return response()->json(['success' => $res, 'message' => $message]);
    }

    public function update_type(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
            'description'  => 'required|string',
        ]);

        if($validator->passes()) {
            $pt = PricingType::findOrFail($id);
            $pt->update($request->only(['name','description']));
            $pt->updated_by = Auth::user()->id;
            $pt->update();
            return response()->json(['success'=> true]);
        } else {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }
    }

}