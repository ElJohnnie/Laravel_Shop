<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['image'];

    public function product(){
        $this->belongsTo(Product::class);
    }
}
