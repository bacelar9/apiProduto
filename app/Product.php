<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'Im',
        'name',  
        'free_shipping',
        'description',
        'price',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
