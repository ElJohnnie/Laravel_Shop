<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpContent extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'subtitle'];

    public function products(){
        return $this->belongsToMany(Product::class, 'up_content_products');
    }
}
