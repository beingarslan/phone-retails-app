<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'slug',
        'price',
        'discount',
        'status',
        'sku',
        'model',
        'ean',
        'image',
        'meta_title',
        'brand_id',
        'category_id',
        'capacity_id',
        'color_id',

    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function capacity(){
        return $this->belongsTo(Capacity::class, 'capacity_id', 'id');
    }

    public function color(){
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }


}
