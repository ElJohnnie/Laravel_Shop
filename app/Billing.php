<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'name', 'lname', 'cep', 'contact', 'address', 'complement', 'number', 'district', 'city', 'state', 'country',
    ];
    
    public function billings()
    {
        return $this->belongsToMany(User::class, 'user_billings');
    }
}
