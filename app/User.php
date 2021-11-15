<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\PasswordResetEmail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'cpf', 'password', 'admin', 'phone', 'celfone', 'cep', 'address', 'complement', 'number', 'district', 'city', 'state', 'country',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
      return $this->hasMany(UserOrder::class);
    }

    public function address()
    {
        return $this->belongsToMany(AddressUser::class, 'user_address');
    }

    public function billings()
    {
        return $this->belongsToMany(Billing::class, 'user_billings');
    }

    public function shippings()
    {
        return $this->belongsToMany(Billing::class, 'user_shippings');
    }

    public function favorites(){
        return $this->belongsToMany(Product::class, 'users_favorites');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetEmail($token));
    }
     
   
}
