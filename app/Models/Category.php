<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=[
        'name',
        'image_slide',
        'image_banner',
    ];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
