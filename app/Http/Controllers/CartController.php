<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class CartController extends Controller
{
    public function index()
    {
        $sellToWhatsCEP = [
            '0' => '95865-000',
            '1' => '95890-000'
        ];
        $user = auth()->user();
        $cart = session()->has('cart') ? session()->get('cart') : [];
        $products = Product::orderBy('id','desc')->take(10)->get();
        return view('front.cart', compact('cart', 'products', 'user', 'sellToWhatsCEP'));
    }

    public function add(Request $request)
    {
        $produto = $request->get('product');

        //verificar se existe sessão para os produtos
        if(session()->has('cart')){
            //existindo eu adiciono esse produto na sessão existente
                //
                $produtos = session()->get('cart'); 
                $slugProduto = array_column($produtos, 'slug');
                if(in_array($produto['slug'], $slugProduto)){
                  $produtos=  $this->dual($produto['slug'], $produto['amount'], $produtos);
                  
                  session()->put('cart', $produtos);
                }else{
                  
                  session()->push('cart', $produto);
                }
        }else{
            //não existindo eu crio a sessão com o primeiro produto
            $produtos[] = $produto;
            //metodo put cria essa sessão com o array e o metodo push acima, atualiza a sessão com os dados 
            
            session()->put('cart', $produtos);
        }
        flash('Produto adicionado no carrinho')->success();
        return redirect()->back();
    }

    public function cartOperator(Request $request){
        $data = $request->all();
        $cart = session()->get('cart');
        $data = $this->cartOpFunction($data['id'], $data['op'], $cart);
        $data = session()->put('cart', $data);
        return response()->json([
            'data' => 'ok'
        ]);
    }

    //passando os parametros no cartOperator, para poupar código, vou fazer as operações com um arrayMap
    private function cartOpFunction($id, $operation, $cart)
    {
        $cart = array_map(function($linha) use($id, $operation){
            if($linha['id'] == $id){
                if($operation == 'add'){
                    $linha['amount'] = ($linha['amount'] + 1);
                }
                if($operation == 'remove'){
                    $linha['amount'] = ($linha['amount'] - 1);
                }
            }
            return $linha;
        }, $cart);
        return $cart;
    }
    
    private function cartFilter($id, $cart){
        $id = $id;
        $cart = array_filter($cart, function($linha) use($id){
            return $linha['id'] == $id;
        });
        $cart = array_pop($cart);
        return $cart;
    }

    private function dual($slug, $quantidade, $produtos)
    {
        $produtos = array_map(function($linha) use($slug, $quantidade){
            if($slug == $linha['slug']){
                $linha['amount'] += $quantidade;
            }
            return $linha;
        }, $produtos);
        return $produtos;
    }


    public function remove($id)
    {
        if(!session()->has('cart')){
            return redirect()->route('cart.index');
        }
        //filtro para remover o produto da sessão do carrinho
        $produtos = session()->get('cart');
    
        //o array filter só vai manter os produtos que sejam diferentes do que é recebido pelo slug
        $produtos = array_filter($produtos, function($linha) use($id){
            return $linha['id'] != $id;
        });
        session()->put('cart', $produtos);
        return redirect()->route('cart.index');
    }

    public function cancel()
    {
        //função Laravel para esquecer a sessão
        $cart = session()->get('cart');
        session()->forget('cart');
        flash('Compra cancelada.')->success();
        return redirect()->route('cart.index');
    }

}
