<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonials.create');
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
            $image = $image->store('testimonial', 'public');
            $data['image'] = $image;
            Testimonial::create($data);
            flash('Testemunho cadastrado com sucesso')->success();
            return redirect()->route('admin.testimonial.index');
        }catch(\Exception $e){
            $message = 'Não foi possível cadastrar o testemunho!'; 
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
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
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
            $testimonial = Testimonial::findOrfail($id);
            $data = $request->all();
            if($request->file('image')){
                if(Storage::disk('public')->exists($testimonial->image)){
                    Storage::disk('public')->delete($testimonial->image);
                }
                $image = $request->file('image');
                $image = $image->store('testimonial', 'public');
                $data['image'] = $image;
            }
            $testimonial->update($data);
            flash('Testemunho editado com sucesso')->success();
            return redirect()->route('admin.testimonial.index');
        }catch(\Exception $e){
            $message = 'Não foi possível cadastrar o testemunho!'; 
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
            $testimonial = Testimonial::findOrFail($id);
            if(Storage::disk('public')->exists($testimonial->image)){
                Storage::disk('public')->delete($testimonial->image);
            }
            $testimonial->delete();
            flash('Testemunho excluído com sucesso')->success();
            return redirect()->route('admin.testimonial.index');
        }catch(\Exception $e){
            $message = 'Não foi possível cadastrar o testemunho!'; 
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }
}
