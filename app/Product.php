<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use hasSlug;

    protected $fillable = ['name', 'meta_tag_title', 'meta_tag_description', 'description', 'body', 'price', 'slug', 'amount', 'sales'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function options(){
        return $this->belongsToMany(Option::class, 'product_options');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function sub_categories(){
        return $this->belongsToMany(SubCategorie::class, 'product_sub_categories');
    }

    public function features(){
        return $this->hasOne(ProductFeature::class);
    }

    public function up_contents(){
        return $this->belongsToMany(UpContent::class, 'up_content_products');
    }

    public function favorites(){
        return $this->belongsToMany(User::class, 'users_favorites');
    }
    
}
