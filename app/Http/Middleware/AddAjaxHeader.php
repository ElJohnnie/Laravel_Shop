<?php

namespace App\Http\Middleware;

use Closure;

class AddAjaxHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->add(['X-Requested-With' => 'XMLHttpRequest']);
        return $next($request);
    }
}
