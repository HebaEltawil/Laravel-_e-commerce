<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        'name',
        'description',
        'price',
        'category_id',
        'quantity',
        'deleted'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function multiimage(){
        return $this->hasMany(MultiImage::class);
    }
}
