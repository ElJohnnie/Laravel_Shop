<?php

namespace App\Http\Middleware;

use Closure;
use App\Product;

class CartOpCheck
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
        $product = Product::findOrFail($data ['id']);
        $cart = session()->get('cart');
        $cart = $this->cartFilter($data , $cart);
        if($data ['op'] == 'add'){
            $cart['amount'] = $cart['amount'] + 1;
        }
        if($data ['op'] == 'remove'){
            $cart['amount'] = $cart['amount'] - 1;
        }
        if($cart['amount'] > $product->amount or $cart['amount'] <= 0 ){
            $notAmount = true;
            $productName = $product->name;
            return response()->json([
                'data' => 'nOk'
            ]);
        }else{
            return $next($request);
        }
    }

    private function cartFilter($product, $cart){
        $id = $product['id'];
        $cart = array_filter($cart, function($linha) use($id){
            return $linha['id'] == $id;
        });
        $cart = array_pop($cart);
        return $cart;
    }
}
