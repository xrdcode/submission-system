<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 4:46
 */

namespace App\Modules\SubmissionManagement\Controllers\Submission;

use App\Models\BaseModel\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function index() {
        $list = Submission::all();
        return view('SubmissionManagement::submission.index', ['list' => $list]);
    }
}