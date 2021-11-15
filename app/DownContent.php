<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownContent extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'subtitle'];

    public function products(){
        return $this->belongsToMany(Product::class, 'down_content_products');
    }
}
