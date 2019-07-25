<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalog extends Model
{
    use SoftDeletes;
 
    protected $dates = ['deleted_at'];
       
    public function category()
    {
        return $this->belongsTo('\App\Category', 'category_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];
}
