<?php

namespace App\Http\Middleware;

use Closure;

class OptionCheck
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
        $data = $request->all();
        $requestProduct = $data['product'];
        if(isset($requestProduct['option'])){
            return $next($request);
        }else{
            $message = 'Se for uma peça de roupa, é necessário escolher uma opção de tamanho.';
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }
}
