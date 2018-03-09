<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 10/03/18
 * Time: 0:21
 */

namespace App\Modules\SubmissionManagement\Controllers\Participant;


use App\Http\Controllers\Controller;
use App\Models\BaseModel\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware(["role:UserMangement-Edit"]);
    }

    public function delete(Request $request, $id) {
        if($request->wantsJson() || $request->ajax()) {
            $user = User::find($id);
            return response()->json(["success" => $user->delete(), "message" => "{$user->name} deleted"]);
        }

        return NotFoundHttpException::class;
    }

    public function recover(Request $request, $id) {
        if($request->wantsJson() || $request->ajax()) {
            $user = User::find($id);
            return response()->json(["success" => $user->undelete(), "message" => "{$user->name} recovered"]);
        }

        return NotFoundHttpException::class;
    }
}