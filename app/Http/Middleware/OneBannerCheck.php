<?php

namespace App\Http\Middleware;

use Closure;
use App\MiddleContent;

class OneBannerCheck
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
        $middleContent = MiddleContent::all();
        if($middleContent->count() > 0){
            return redirect()->back();
        }else{
            return $next($request);
        }
    }
}
