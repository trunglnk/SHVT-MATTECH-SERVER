<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $name = $request->route()->getName();
        if (empty($name) || $name != 'group-desktop-files.download')
            $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
