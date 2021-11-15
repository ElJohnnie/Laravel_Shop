<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = [
        'name', 'lname', 'cep', 'contact', 'address', 'complement', 'number', 'district', 'city', 'state', 'country',
    ];
    
    public function shippings()
    {
        return $this->belongsToMany(User::class, 'user_shippings');
    }
}
