<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    public $timestamps = false;
    protected $fillable = ['reference', 'pagseguro_status', 'pagseguro_code', 'data_compra', 'itens', 'user_id', 'value', 'type', 'link_boleto', 'billing_address', 'codigo_envio', 'status_envio'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
