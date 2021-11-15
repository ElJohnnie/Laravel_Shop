<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductsimagesController extends Controller
{
    public function removeImage(Request $request){
        //buscar imagem pelo nome no banco de dados

        $imageName = $request->get('imageName');
        //removo dos arquivos

        
        if(Storage::disk('public')->exists($imageName)){
            
            Storage::disk('public')->delete($imageName);
        }

        //removo do banco
        $image = ProductImage::where('image', $imageName);
        //pegar o id do produto para o redirect
        $product = $image->first()->product_id;
        $image->delete();

        flash('imagem removida com sucesso')->success();
        return redirect()->route('admin.products.edit', ['product' => $product]);

        
    }
}
