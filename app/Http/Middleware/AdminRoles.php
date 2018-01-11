<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
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
            // GOD PERMISSION //
            if(Auth::id() == 1)
                return $next($request);
            if (!Auth::user()->hasRole($roleName))
            {
                if($request->wantsJson() || $request->ajax())
                    return response()->json(['error' => 'Not Authorized'], Response::HTTP_UNAUTHORIZED);
                return redirect()->route('admin.dashboard');
            }
        } else {
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}
