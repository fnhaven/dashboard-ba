<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id');
    }

    public function user_address()
    {
        return $this->belongsTo('\App\UserAdress', 'user_address_id');
    }
}
