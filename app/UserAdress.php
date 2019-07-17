<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdress extends Model
{
    protected $table = 'user_address';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];
}
