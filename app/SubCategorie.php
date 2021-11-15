<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class SubCategorie extends Model
{
    use hasSlug;

    
    protected $fillable = ['name', 'description', 'meta_tag_title', 'meta_tag_description', 'slug'];
    
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'product_sub_categories');
    }

    public function categories(){
        return $this->belongsTo(Category::class);
    }
}
