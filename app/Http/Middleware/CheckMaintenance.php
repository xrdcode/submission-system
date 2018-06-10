<?php

namespace App\Http\Middleware;

use Closure;

class CheckMaintenance
{
    protected $request;
    protected $app;
    public function __construct(Application $app, Request $request)

    {
        $this->app = $app;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  IlluminateHttpRequest  $request
     * @param  Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)

    {
        if ($this->app->isDownForMaintenance() &&
            !in_array($this->request->getClientIp(), ['120.0.0.1','103.8.12.99','10.102.0.51'])) //add IP addresses you want to exclude
        {
            throw new HttpException(503);

        }
        return $next($request);

    }
}
