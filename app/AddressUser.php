<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressUser extends Model
{
    protected $fillable = [
        'name', 'lname', 'cep', 'contact', 'address', 'complement', 'number', 'district', 'city', 'state', 'country',
    ];

    public function address()
    {
        return $this->belongsToMany(User::class, 'user_address');
    }

}
