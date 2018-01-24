<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\MasterdataManagement\Controllers\Workstate;

use App\Http\Controllers\Controller;

use App\Models\BaseModel\Workstate;
use App\Models\BaseModel\WorkstateType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:MasterdataManagement-Create'])->only(['store','new']);
        $this->middleware(['role:MasterdataManagement-Save'])->only(['update','index','activate']);
    }

    public function index($id) {
        $ws = Workstate::findOrFail($id);
        $data = [
            'action'    => route('admin.master.workstate.update', $id),
            'modalId'   => 'wsmodal',
            'title'     => 'New Workstate',
            'ws'        => $ws,
            'typelist'  => WorkstateType::getSelectableList()
        ];
        return view("MasterdataManagement::Workstate.medit", $data);
    }


    public function newws() {
        $data = [
            'action'    => route('admin.master.workstate.store'),
            'modalId'   => 'wsmodal',
            'title'     => 'New Workstate',
            'typelist'  => WorkstateType::getSelectableList()
        ];
        return view("MasterdataManagement::Workstate.new", $data);
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $ws = Workstate::find($id);
            $ws->updated_at = Carbon::now()->toDateTimeString();
            $ws->updated_by = Auth::user()->id;
            $ws->update($request->only(['name','description']));
            return response()->json([$ws]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }

    public function activate($id) {
        $ws = Workstate::find($id);
        $ws->active = true;
        return response()->json($ws->saveOrFail());
    }

    protected function validator(Request $request) {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:modules,name,' . $request->id,
            'description' => 'required|string|max:255',
            'workstate_type_id' => 'required'
        ]);
    }

    /**
     * Minmal usia pendaftar 17tahun
     * @return string
     */
    protected function maxYear() {
        return Carbon::now()->addYears('-17')->addDays('1')->toDateString();
    }

    public function store(Request $request) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $ws = new Workstate();
            $ws = $ws->create($request->all());
            $ws->created_by = Auth::user()->id;
            $ws->updated_by = Auth::user()->id;
            $ws->update();
            return response()->json([$ws]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }




}