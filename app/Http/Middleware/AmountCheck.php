<?php

namespace App\Http\Middleware;

use Closure;
use App\Product;

class AmountCheck
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
        
        $product = Product::findOrFail($request->product['id']); 
        $requestProduct = $request->all();
        $requestProduct = $requestProduct['product'];
        if(session()->has('cart')){
            $cart = session()->get('cart');
            $cart = $this->cartFilter($requestProduct, $cart);
            $total = ($cart['amount'] + $requestProduct['amount']);
            if($total > $product->amount){
                $notAmount = true;
                $productName = $requestProduct['name'];
                return redirect()->back()->with([
                    'notAmount' => $notAmount,
                    'productName'=> $productName
                ]);
            }
        }else{
            if($requestProduct['amount'] > $product->amount){
                $notAmount = true;
                $productName = $requestProduct['name'];
                return redirect()->back()->with([
                    'notAmount' => $notAmount,
                    'productName'=> $productName
                ]);
            }
        }

        return $next($request);
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
