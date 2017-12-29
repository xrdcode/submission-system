<?php

namespace App\Modules\User\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return View("User::login");
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $credential = $this->credentials($request, false);
        if(Auth::validate($credential)) {
            $user = User::where($this->username(), $request->{$this->username()})->first();
            if(!$user->active) {
                $errors = [$this->username() => trans('auth.notverified')];
            }
        } else {
            $errors = [$this->username() => trans('auth.failed')];
        }


        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request, $activeCheck = true)
    {
        $req = $request->only($this->username(), 'password');
        if($activeCheck) {
            return array_add($req, 'active',1);
        } else {
            return $req;
        }
    }
}
