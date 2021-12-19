<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacity extends Model
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
        return $this->hasMany(Product::class, 'capacity_id', 'id');
    }
}
