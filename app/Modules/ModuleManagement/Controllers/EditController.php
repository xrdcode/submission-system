<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/09/2017
 * Time: 22:50
 */

namespace App\Modules\ModuleManagement\Controllers;


use App\Http\Controllers\Controller;

use App\Models\BaseModel\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class EditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:AdminManagement-Create'])->only(['store','addadmin']);
        $this->middleware(['role:AdminManagement-Save'])->only(['update','index','activate']);
    }

    public function index($id) {
        $module = Module::findOrFail($id);
        return view("ModuleManagement::edit", ["module" => $module]);
    }


    public function newmodule() {
        $data = [
            'action' => route('module.manage.store'),
            // 'class' => 'modal-lg', //Kelas Modal
            'modalId'   => 'modulemodal',
            'title'     => 'Register New Module'
        ];
        return view("ModuleManagement::new", $data);
    }

    public function update(Request $request, $id) {
        $validator = $this->validator($request);

        if($validator->passes()) {
            $module = Module::find($id);
            $module->updated_at = Carbon::now()->toDateTimeString();
            $module->updated_by = Auth::user()->id;
            $module->update($request->only(['name','description','pathname']));
            return response()->json([$module]);
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
            'name' => 'required|string|max:255|unique:modules,name,' . $request->id,
            'pathname' => 'required|string|max:255|unique:modules,pathname,' . $request->id,
            'description' => 'required|string|max:255',
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
            $module = new Module();
            $module = $module->create($request->all());
            $module->updated_at = Carbon::now()->toDateTimeString();
            $module->updated_by = Auth::user()->id;
            $module->update();
            return response()->json([$module]);
        } else {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
    }


}