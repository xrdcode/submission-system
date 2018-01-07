<?php

namespace App\Modules\User\Controllers\Auth;

use App\Models\BaseModel\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendVerificationEmail;
use Illuminate\Support\Facades\Validator;

class ResendVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Resend Confirmation Page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('User::resendverification');
    }

    /**
     * @param array $data
     * @return mixed
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|is_registered',
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendVerification(Request $request) {
        $this->validator($request->all())->validate();

        $user = User::where('email','=', $request->email)->first();

        dispatch(new SendVerificationEmail($user));

        return view('User::verification');
    }
}
