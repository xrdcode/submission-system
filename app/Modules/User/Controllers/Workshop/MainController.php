<?php
/**
 * Created by PhpStorm.
 * User: reysd
 * Date: 05/02/2018
 * Time: 11.55
 */

namespace App\Modules\User\Controllers\Workshop;


use App\Models\BaseModel\SubmissionEvent;
use http\Env\Request;
use Validator;
use Illuminate\Routing\Controller;

class MainController extends Controller
{
    public function index() {
        $this->data['header'] = "Workshop List";
        return view("User::workshop.index", $this->data);
    }

    public function edit() {

    }

    public function validator(Request $request) {
        return Validator::make($request->all(), [
           'submission_event_id'    => 'required|numeric',
           'pricing_id'             => 'required|numeric'
        ]);
    }

    public function store() {

    }

    public function update() {

    }


    ///
    /// API
    ///

    public function json_pricelist($id) {
        $event = SubmissionEvent::find($id);
        return response()->json($event->workshoplist());

    }


}