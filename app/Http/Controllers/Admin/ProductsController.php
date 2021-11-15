<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductsRequest;
use App\Product;
use App\User;
use App\Category;
use App\Option;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadTrait;

class ProductsController extends Controller
{

    use UploadTrait;

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::paginate(10);
        $products = $this->product->orderBy('id','desc')->paginate(50);
        return view('admin.products.index', compact('products', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all(['id', 'name']);
        $options = Option::all();
        return view('admin.products.create', compact('categories','options'));
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
            $dataFeatures = [
                'weight' => $data['weight'],
                'lenght' => $data['lenght'],
                'height' => $data['height'],
                'width' => $data['width'],
                'diameter' => $data['diameter'],
            ];
            $user_id = auth()->user()->id;
            $user = User::findOrFail($user_id);
            $categories = $request->get('categories', null);
            $subcategories = $request->get('sub_categories', null);
            $options = $request->get('options', null);
            $product = $user->products()->create($data);
            $product->options()->sync($options);
            $product->categories()->sync($categories);
            $product->sub_categories()->sync($subcategories);
            $product->features()->create($dataFeatures);
            //adição das fotos do produto
            if($request->has('photos')){
                //arquivos e o campo que vai ser posto o dado
                $images = $this->uploadImage($request->file('photos'), 'image');
                $product->images()->createMany($images);
            }
            flash('Produto cadastrado com sucesso')->success();
            return redirect()->route('admin.products.index');
        }catch(\Exception $e){
            //$message = 'Não foi possível criar o produto!'; 
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($e->getMessage())->warning();
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
    public function edit($product)
    {
        $categories = Category::all(['id', 'name']);
        $options = Option::all();
        $product = $this->product->findOrFail($product);
        return view('admin.products.edit', compact('product', 'categories', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request, $product)
    {
        try{
            $data = $request->all();
            $dataFeatures = [
                'weight' => $data['weight'],
                'lenght' => $data['lenght'],
                'height' => $data['height'],
                'width' => $data['width'],
                'diameter' => $data['diameter'],
            ];
            $products = $this->product->findOrFail($product);
            $categories = $request->get('categories');
            $subcategories = $request->get('sub_categories');
            $options = $request->get('options', null);
            $products->update($data);
            $products->features()->update($dataFeatures);
            if(!is_null($options)){
                $products->options()->sync($options);
            }else{
                $products->options()->detach($options);
            }
            if(!is_null($categories)){
                $products->categories()->sync($categories);
            }else{
                $products->categories()->detach($categories);
            }
            if(!is_null($subcategories)){
                $products->sub_categories()->sync($subcategories);
            }else{
                $products->sub_categories()->detach($subcategories);
            }
            //adição das fotos do produto
            if($request->has('photos')){
                //arquivos e o campo que vai ser posto o dado
                $images = $this->uploadImage($request->file('photos'), 'image');
                $products->images()->createMany($images);
            }
            flash('Produto editado com sucesso')->success();
            return redirect()->route('admin.products.index');
        }catch(\Exception $e){
            $message = 'Não foi possível atualizar o produto!'; 
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
    public function destroy($product)
    {
        try{
            $product = $this->product->findOrFail($product);
            foreach($product->images as $photos){ 
                if(Storage::disk('public')->exists($photos->image)){
                    Storage::disk('public')->delete($photos->image);
                }
            }
            $product->images()->delete();
            $product->features()->delete();
            $product->categories()->detach();
            $product->sub_categories()->detach();
            $product->delete();
            flash('Produto excluído com sucesso')->success();
            return redirect()->route('admin.products.index');
        }catch(\Exception $e){
            $message = 'Não foi possível excluir o produto!'; 
            if(env('APP_DEBUG')) {
            $message = $e->getMessage();
            }
            flash($message)->warning();
            return redirect()->back()->withInput();
        }
    }
}
