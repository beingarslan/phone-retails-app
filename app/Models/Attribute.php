<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'slug',
        'type',
        'status',
        'sort_order'
    ];

    public function categoryAttribute()
    {
        return $this->hasMany(CategoryAttribute::class, 'attribute_id', 'id');
    }


}
