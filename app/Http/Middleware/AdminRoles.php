<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roleName)
    {
        if(Auth::guard("admin")->check()) {
            if (!Auth::user()->hasRole($roleName))
            {
                return redirect()->route('admin.dashboard');
            }
        } else {
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}
