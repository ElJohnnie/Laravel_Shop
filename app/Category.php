<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use hasSlug;

    
    protected $fillable = ['name', 'description', 'meta_tag_title', 'meta_tag_description', 'slug', 'position'];
    
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    public function sub_categories(){
        return $this->hasMany(SubCategorie::class);
    }
}
