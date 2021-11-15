<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Front;
use App\Product;
use App\Traits\UploadTrait;

class FrontimagesController extends Controller
{
    use UploadTrait;

    private $front;

    public function __construct(Front $front)
    {
        $this->front = $front;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Front::all();
        return view('admin.frontend.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.frontend.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if($request['allNull']){
            $request['span'] = null;
            $request['title'] = null;
            $request['description'] = null;
            $request['button'] = null;
        }
        $data = $request->all();
        if(!$request->has('buttonCheck')){
            $data['button'] = null;
        }
        if($request->has('banner')){  
            $banner = $request->file('banner')->store('banner', 'public');
            $data['banner'] = $banner;                         
        }
        $this->front->create($data);
        flash('Banner criado com sucesso')->success();
        return redirect()->route('admin.frontend.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = $this->front::FindOrFail($id);

        if(Storage::disk('public')->exists($banner->banner)){
            Storage::disk('public')->delete($banner->banner);
        }
        
        $banner->delete();
        flash('Banner excluído com sucesso')->success();
        return redirect()->route('admin.frontend.index');

    }
}
