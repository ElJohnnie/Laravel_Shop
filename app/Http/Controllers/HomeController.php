<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Front;
use App\Header;
use App\UpContent;
use App\MiddleContent;
use App\DownContent;
use App\Testimonial;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::orderBy('id','desc')->take(10)->get();
        $upContent = UpContent::all();
        $midContent = MiddleContent::all();
        $downContent = DownContent::all();
        $banners =  Header::all();
        $testimonials =  Testimonial::all();
        return view('welcome', compact('products', 'banners', 'upContent', 'midContent', 'testimonials', 'downContent'));
    }
    public function single($slug)
    {
        $products = Product::orderBy('id','desc')->take(10)->get();
        $product = Product::whereSlug($slug)->with('categories','options')->first();
        $images = $product->images();
        return view('front.single', compact('product', 'products', 'images'));

    }
}