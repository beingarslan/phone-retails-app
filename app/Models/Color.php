<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'slug',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'color_id', 'id');
    }
}
