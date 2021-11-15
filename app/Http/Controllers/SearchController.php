<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class SearchController extends Controller
{
    public function index(Request $request){
        $data = $request->all();
        $products = Product::where('name', 'LIKE', '%' . $data['search'] . '%')->get();
        return view('front.search', compact('products'));
    }
}
