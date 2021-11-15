<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Header;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Header::orderBy('id', 'DESC')->get();
        return view('admin.frontend.header.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.frontend.header.create', compact('products'));
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
            $banners = $request->file('banner');
            $banners = $banners->store('banner', 'public');
            $data['banner'] = $banners;
            Header::create($data);
            flash('Banner cadastrado com sucesso')->success();
            return redirect()->route('admin.header.index');
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
        $products = Product::all();
        $banner = Header::findOrFail($id);
        return view('admin.frontend.header.edit', compact('banner', 'products'));
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
            if(!isset($data['product_id'])){
                $data['product_id'] = null;
            }
            $banner = Header::findOrFail($id);
            if($request->file('banner')){
                if(Storage::disk('public')->exists($banner->banner)){
                    Storage::disk('public')->delete($banner->banner);
                }
                $banners = $request->file('banner');
                $banners = $banners->store('banner', 'public');
                $data['banner'] = $banners;
            }
            $banner->update($data);
            flash('Banner atualizado com sucesso')->success();
            return redirect()->route('admin.header.index');
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
            $banner = Header::findOrFail($id);
            if(Storage::disk('public')->exists($banner->banner)){
                Storage::disk('public')->delete($banner->banner);
            }
            $banner->delete();
            flash('Banner excluído com sucesso')->success();
            return redirect()->route('admin.header.index');
        }catch(\Exception $e){

        }
    }
}
