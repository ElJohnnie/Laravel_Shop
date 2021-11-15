<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    public $timestamps = false;
    protected $fillable = ['weight', 'lenght', 'height', 'width', 'diameter'];

    public function product(){
        $this->belongsTo(Product::class);
    }
}
