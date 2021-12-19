<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'status', 'website', 'status', 'logo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }
}
