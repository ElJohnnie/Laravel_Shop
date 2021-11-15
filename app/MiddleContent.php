<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MiddleContent extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'subtitle', 'tag', 'image'];

    public function products(){
        return $this->belongsToMany(Product::class, 'middle_content_products');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'middle_content_products');
    }

    public function sub_categories(){
        return $this->belongsToMany(SubCategorie::class, 'middle_content_products');
    }
}
