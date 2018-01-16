<?php

namespace App\Http\Middleware;

use App\Helper\HtmlHelper;
use Closure;
use Illuminate\Support\Facades\Auth;

class PersonalDataMustCompleted
{
    protected $bypass = ['user.profile.update','user.profile'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::guard("user")->check()) {
            return redirect()->route('user.dashboard');
        } else {
            if(!Auth::user()->personal_data_filled()) {
                $message = HtmlHelper::alert("Attention!","Please complete your personal data before continuing to apply submission.", "alert-warning", false);
                $request->session()->flash('message', $message);
                if(!in_array($request->route()->getName(), $this->bypass))
                    return redirect()->route('user.profile');
            }
        }

        return $next($request);
    }
}
