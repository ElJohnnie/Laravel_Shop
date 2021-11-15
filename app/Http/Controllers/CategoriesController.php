<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\SubCategorie;

class CategoriesController extends Controller
{
    public function index($category)
    {     
        $categories = Category::with('products')->where('slug', $category)->get();
        return view('front.category', compact('categories'));
    }
    public function subCategoryIndex($category)
    {     
        $categories = SubCategorie::with('products')->where('slug', $category)->get();
        return view('front.category', compact('categories'));
    }
}
