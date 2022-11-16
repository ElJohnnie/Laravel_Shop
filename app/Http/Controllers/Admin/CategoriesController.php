<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\SubCategorie;

class CategoriesController extends Controller
{
    private $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->orderBy('position')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));
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
            if(isset($data['as_sub'])){
                $category = Category::findOrFail($data['categorie']);
                $category->sub_categories()->create($data);
                flash('Sub-categoria cadastrada com sucesso')->success();
                return redirect()->route('admin.categories.index');
            }else{
                $categories = Category::all();
                foreach($categories as $c){
                    if($c->position == $data['position']){
                        $c->position = count($categories)+1;
                        $c->update();
                    }
                }
                Category::create($data);
                flash('Categoria cadastrada com sucesso')->success();
                return redirect()->route('admin.categories.index');
            }
        }
        catch(\Exception $e){
            $message = 'Não foi possível criar categoria!';
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
    public function show($category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {
        $categories = $this->category->all();
        $category = $this->category->findOrFail($category);
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function editSubCategory($category)
    {
        $category = SubCategorie::findOrFail($category);
        $categories = Category::with('sub_categories')->get();
        return view('admin.categories.edit-subcategories', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category)
    {
        try {
            $id = $category;
            $data = $request->all();
            if (isset($data['as_sub'])) {
                $category = Category::findOrFail($data['categorie']);
                $category->sub_categories()->create($data);
                $category = Category::findOrFail($id);
                $category->delete();
                flash('Categoria editada com sucesso')->success();
                return redirect()->route('admin.categories.index');
            }
            $category = Category::findOrFail($category);
            $categories = Category::all();
            foreach ($categories as $c) {
                if ($c->position == $data['position']) {
                    $c->position = $category->position;
                    $c->update();
                }
            }
            $category->update($data);
            flash('Categoria editada com sucesso')->success();
            return redirect()->route('admin.categories.index');

        }catch(\Exception $e){
            $message = 'Não foi possível atualizar categoria!';
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }
    public function updateSubCategories(Request $request, $category)
    {
        try{
            $data = $request->all();
            if(!isset($data['as_sub'])){
                $categories = Category::all();
                foreach($categories as $c){
                    if($c->position == $data['position']){
                        flash("Já existe uma categoria na posição selecionada.")->warning();
                        return redirect()->back()->withInput();
                    }else{
                       Category::Create($data);
                       $subCategory = SubCategorie::findOrFail($category);
                       $subCategory->delete();
                       flash('Categoria editada com sucesso')->success();
                        return redirect()->route('admin.categories.index');
                    }

                }
                $category = SubCategorie::findOrFail($category);
                $category->delete();
                flash('Categoria editada com sucesso')->success();
                return redirect()->route('admin.categories.index');
            }
            $category = SubCategorie::findOrFail($category);
            $category->update($data);
            flash('Categoria editada com sucesso')->success();
            return redirect()->route('admin.categories.index');

        }catch(\Exception $e){
            $message = 'Não foi possível atualizar categoria!';
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
    public function destroy($category)
    {
        try{
            $category = $this->category->findOrFail($category);
            $category->delete();
            flash('Categoria excluída com sucesso')->success();
            return redirect()->route('admin.categories.index');
        }catch(\Exception $e){
            $message = 'Não foi possível excluir categoria!';
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }

    public function destroySubCategory($category)
    {
        try{
            $category = SubCategorie::findOrFail($category);
            $category->delete();
            flash('Subcategoria excluída com sucesso')->success();
            return redirect()->route('admin.categories.index');
        }catch(\Exception $e){
            $message = 'Não foi possível excluir categoria!';
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }
}
