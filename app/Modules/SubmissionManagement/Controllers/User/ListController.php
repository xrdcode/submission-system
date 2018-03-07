<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 07/03/18
 * Time: 9:25
 */

namespace App\Modules\SubmissionManagement\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\BaseModel\User;
use Yajra\Datatables\Datatables;

class ListController extends Controller
{
    public function index() {
        $data['users'] = User::all();
        return view("SubmissionManagement::user.index", $data);
    }

    public function DT() {
        $users = User::query();
        $datatable = Datatables::of($users);

        return $datatable->make(true);
    }
}