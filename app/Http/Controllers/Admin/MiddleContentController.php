<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\MiddleContent;
use App\Product;
use App\Category;
use App\SubCategorie;

class MiddleContentController extends Controller
{

    public function __construct()
    {

        $this->middleware('oneBanner.check')->only('create');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = MiddleContent::with('products', 'categories', 'sub_categories')->orderBY('id', 'DESC')->get();
        return view('admin.frontend.midcontent.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $categories = Category::all();
        $sub_categories = SubCategorie::all();
        return view('admin.frontend.midcontent.create', compact('products', 'categories', 'sub_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $data = $request->all();
            $image = $request->file('image');
            $image = $image->store('banner', 'public');
            $data['image'] = $image;
            $midcontent = MiddleContent::create($data);
            $products = $request->get('product_id', null);
            $categories = $request->get('category_id', null);
            $subcategories = $request->get('subcategory_id', null);
            $midcontent->products()->sync($products);
            $midcontent->categories()->sync($categories);
            $midcontent->sub_categories()->sync($subcategories);
            flash('Conteúdo cadastrado com sucesso')->success();
            return redirect()->route('admin.midcontent.index');
            
        }catch(\Exception $e){
            $message = 'Não foi possível cadastrar o banner!'; 
            if(env('APP_DEBUG')) {
                $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = MiddleContent::findOrFail($id);
        $products = Product::all();
        $categories = Category::all();
        $sub_categories = SubCategorie::all();
        return view('admin.frontend.midcontent.edit', compact('products', 'categories', 'sub_categories', 'content'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->all();
            $midContent = MiddleContent::findOrFail($id);
            if($request->file('image')){
                if(Storage::disk('public')->exists($midContent->image)){
                    Storage::disk('public')->delete($midContent->image);
                }
                $banners = $request->file('image');
                $banners = $banners->store('banner', 'public');
                $data['image'] = $banners;
            }
            $midContent->update($data);
            $products = $request->get('product_id', null);
            $categories = $request->get('category_id', null);
            $subcategories = $request->get('subcategory_id', null);
            if($products == null && $midContent->products->count() > 0){
                $midContent->products()->detach();
            }
            if($categories == null && $midContent->categories->count() > 0){
                $midContent->categories()->detach();
            }
            if($subcategories == null && $midContent->sub_categories->count() > 0){
                $midContent->sub_categories()->detach();
            }
            $midContent->products()->sync($products);
            $midContent->categories()->sync($categories);
            $midContent->sub_categories()->sync($subcategories);
            flash('Conteúdo atualizado com sucesso')->success();
            return redirect()->route('admin.midcontent.index');
        }catch(\Exception $e){
            $message = 'Não foi possível atualizar o banner!'; 
            if(env('APP_DEBUG')) {
                $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $content = MiddleContent::findOrFail($id);
            $content->delete();
            $content->products()->detach();
            $content->categories()->detach();
            $content->sub_categories()->detach();
            flash('Conteúdo deletado com sucesso')->success();
            return redirect()->route('admin.midcontent.index');
        }catch(\Exception $e){
            $message = 'Não foi possível excluir o banner!'; 
            if(env('APP_DEBUG')) {
                $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }
}
