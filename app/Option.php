<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Option extends Model
{
    use hasSlug;

    protected $fillable = ['type', 'name', 'description', 'slug'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'product_options');
    }

    
}
