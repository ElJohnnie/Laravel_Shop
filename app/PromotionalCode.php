<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionalCode extends Model
{
    protected $fillable = [
        'code', 'percent', 
    ];
}
