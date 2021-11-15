<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class CartOptionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cart = session()->has('cart') ? session()->get('cart') : [];
        $products = Product::orderBy('id','desc')->take(10)->get();
        return view('front.cart', compact('cart', 'products', 'user'));
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
                $optionProduto = array_column($produtos, 'option');
                if(in_array($produto['option'], $optionProduto) && in_array($produto['slug'], $slugProduto)){
                    $produtos = $this->dual($produto['slug'], $produto['amount'], $produto['option'], $produtos);
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
        $data = $this->cartOpFunction($data['id'], $data['op'], $data['option'], $cart);
        $data = session()->put('cart', $data);
        return response()->json([
            'data' => 'ok'
        ]);
    }

    //passando os parametros no cartOperator, para poupar código, vou fazer as operações com um arrayMap
    private function cartOpFunction($id, $operation, $option, $cart)
    {
        $cart = array_map(function($linha) use($id, $option, $operation){
            if($linha['id'] == $id && $linha['option'] == $option){
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

    private function dual($slug, $quantidade, $option, $produtos)
    {
        $produtos = array_map(function($linha) use($slug, $quantidade, $option){
            if($slug == $linha['slug'] && $option == $linha['option']){
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

    public function removeJS(Request $request)
    {
        if(!session()->has('cart')){
            return redirect()->route('cart.index');
        }
        //filtro para remover o produto da sessão do carrinho
        $data = $request->all();
        $produtos = session()->get('cart');
        //o array filter só vai manter os produtos que sejam diferentes do que é recebido pelo slug
        $produtos = array_filter($produtos, function($linha) use($data){
            return $linha['option'] != $data['option'];
        });

        session()->put('cart', $produtos);
        return response()->json([
            'data' => 'ok'
        ]);
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
