<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 05/10/2017
 * Time: 9:23
 */

namespace App\Modules\Admin\Controllers;


use App\Http\Controllers\Controller;
use App\Models\BaseModel\SystemSetting;
use App\Models\SiteSetting;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteSettingController extends Controller
{
    public function index() {
        $setting = SystemSetting::all();
        return view('Admin::settings', ['settings' => $setting]);
    }

    public function update(Request $request) {
        if($request->ajax()) {
            $response = [];
            $err = [];
            foreach($request->all()['setting'] as $dt)
            {
                $validator = $this->validator($dt);
                if(!$validator->passes()) {
                    $err[$dt['name']] = $validator->getMessageBag()->toArray();
                    $response['error'] = $err;
                } else {
                    SystemSetting::setSetting($dt['name'], $dt['value']);
                }
            }
            return response()->json(['response' => $response]);
        }

    }


    /**
     * @param array $data
     * @return mixed
     */
    public function validator(array $data) {
        return Validator::make($data, [

        ]);
    }
}