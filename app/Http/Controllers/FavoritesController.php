<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;

class FavoritesController extends Controller
{
    public function favorite(Request $request){
        try{
            $data = $request->all();
            $user = auth()->user();
            $product = Product::findOrFail($data['product']);
            $user->favorites()->attach($product);
            return response()->json([
                'data' => 'ok'
            ]);
        }catch(\Exception $e){
            //$message = 'Não foi possível criar o produto!';
            if(env('APP_DEBUG')) {
                $message = $e->getMessage();
            }
            return response()->json([
                'data' => 'nOk'
            ]);
        }
    }
    public function unfavorite(Request $request){
        try{
            $data = $request->all();
            $user = auth()->user();
            $product = Product::findOrFail($data['product']);
            $user->favorites()->detach($product);
            return response()->json([
                'data' => 'ok'
            ]);
        }catch(\Exception $e){
            //$message = 'Não foi possível criar o produto!';
            if(env('APP_DEBUG')) {
                $message = $e->getMessage();
            }
            return response()->json([
                'data' => 'nOk'
            ]);
        }
    }
}
