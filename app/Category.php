<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function is_root()
    {
        return $this->depth == 1;
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($category) { 
             $category->childrens()->delete();
        });
    }
}
