<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\DownContent;

class DownContentController extends Controller
{

    public function __construct(DownContent $downcontent)
    {
        $this->downcontent = $downcontent;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = DownContent::with('products')->get();
        return view('admin.frontend.downcontent.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.frontend.downcontent.create', compact('products'));
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
            $products = $request->get('products');
            $content = $this->downcontent->create($data);
            $content->products()->sync($products);
            flash('Conteúdo cadastrado com sucesso')->success();
            return redirect()->route('admin.downcontent.index');

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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Product::all();
        $content = DownContent::findOrFail($id);
        return view('admin.frontend.downcontent.edit', compact('products', 'content'));
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
            $content = DownContent::findOrFail($id);
            $product = $request->get('products');
            $content->update($data);
            if(!is_null($product)){
                $content->products()->sync($product);
            }else{
                $content->products()->detach($product);
            }
            flash('Conteúdo atualizado com sucesso')->success();
            return redirect()->route('admin.downcontent.index');
        }catch(\Exception $e){
            $message = 'Não foi possível editar o banner!';
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
            $content = DownContent::findOrFail($id);
            $content->delete();
            $content->products()->detach();
            flash('Conteúdo deletado com sucesso')->success();
            return redirect()->route('admin.downcontent.index');
        }catch(\Exception $e){
            $message = 'Não foi possível editar o conteúdo!';
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }
}
