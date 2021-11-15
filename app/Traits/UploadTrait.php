<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UploadTrait {

    private function uploadImage($images, $imageColumn = null)
    {

        //$imagens = $request->file('fotos');

        $imagesUp = [];


        if(is_array($images)){
            
            foreach($images as $image){
            
                $imagesUp[] = [$imageColumn => $image->store('products', 'public')];

                } 

            }

        return $imagesUp;

    }

}

?>