<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Option;

class OptionsController extends Controller
{

    private $option;

    public function __construct(Option $option)
    {
        $this->option = $option;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = $this->option->orderBy('id', 'DESC')->get();
        return view('admin.options.index',compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.options.create');
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
            $this->option->create($data);
            flash('Opção cadastrada com sucesso')->success();
            return redirect()->route('admin.options.index');
        }catch(\Exception $e){
            $message = 'Não foi possível cadastrar a opção!'; 
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
        $option = $this->option->findOrFail($id);
        return view('admin.options.edit', compact('option'));
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
            $option = $this->option->findOrFail($id);
            $option->update($data);
            flash('Opção atualizada com sucesso')->success();
            return redirect()->route('admin.options.index');
        }catch(\Exception $e){
            $message = 'Não foi possível atualizar a opção!'; 
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
            $option = $this->option->findOrFail($id);
            $option->delete();
            flash('Opção excluída com sucesso')->success();
            return redirect()->route('admin.options.index');
        }catch(\Exception $e){
            $message = 'Não foi possível excluir a opção!'; 
            if(env('APP_DEBUG')) {
                $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }
}
