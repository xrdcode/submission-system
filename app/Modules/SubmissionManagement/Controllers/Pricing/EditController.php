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
use App\Models\BaseModel\Pricing;
use App\Modules\SubmissionManagement\Models\SubmissionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Carbon\Carbon;

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
            'action'        => route('admin.event.update', $id),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'eventmodal',
            'title'         => 'Create New Event'
        ];
        return view("SubmissionManagement::pricing.medit", $data);
    }


    public function newprice() {
        $data = [
            'action'        => route('admin.pricing.store'),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'       => 'pricingmodel',
            'title'         => 'Create New Price',
            'eventlist'    => SubmissionEvent::getlist(),
            'typelist'    => PricingType::getList(),
        ];
        return view("SubmissionManagement::pricing.new", $data);
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $pricing = Pricing::find($id);

            if(!empty($request->get('parent'))) {
                $pricing->parent_id = $request->get('parent');
            } else {
                $pricing->parent_id = null;
            }

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


}