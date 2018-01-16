<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 15/01/2018
 * Time: 16:42
 */

namespace App\Modules\User\Controllers;


use App\Helper\HtmlHelper;
use App\Http\Controllers\Controller;
use App\Models\BaseModel\PersonalData;
use App\Models\BaseModel\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PersonalDataController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        $message = $request->session()->get('message');
        return view("User::profile.index", compact(['user','message']));
    }

    public function update(Request $request) {

        $validator = Validator::make($request->all(),[
            "name"      => "required|string|max:150",
            "address"   => "required|string|max:190",
            "phone"     => "required|numeric",
            "birthdate" => "required|string",
            "student"   => "required|string",
            "nik"               => "required|string",
            "identity_type_id"  => "required|numeric",
            "identity_number"   => "required|string",
            "institution"       => "required|string",
            "department"        => "required|string",
        ]);

        if($validator->passes()) {
            $user = Auth::user();
            if(empty($user->personal_data)) {
               $pd  = new PersonalData();
               $pd->user_id = $user->id;
               $pd->setRawAttributes($request->only(['nik','institution','department','identity_number','identity_type_id']));
               $pd->user()->associate($user);
               $pd->save();
            } else {
                $user->personal_data()->update($request->only(['nik','institution','department','identity_number','identity_type_id']));
            }
            $user->update($request->only(['name','address','phone','birthdate','student']));
            return response()->json(['success' => true]);
        } else {
            return response()->json(['data' => $request->all(),'errors' => $validator->getMessageBag()->toArray()], 200);
        }
    }
}