<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'image',
        'status',
        'parent_id',
        'created_at',
        'update_at'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
    public function child()
    {
        return $this->hasOne(Category::class, 'parent_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function categoryAttribute()
    {
        return $this->hasMany(CategoryAttribute::class, 'category_id', 'id');
    }
    // attributes
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, CategoryAttribute::class, 'category_id', 'attribute_id');
    }

    public function attribute()
    {
        return $this->belongsToMany(Attribute::class, CategoryAttribute::class, 'category_id', 'attribute_id');
    }
}
