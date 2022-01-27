<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    // table name
    protected $table = 'product_attributes';

    // fillable
    protected $fillable =[
        'id',
        'value',
        'product_id',
        'attribute_id',
    ];

    // relationbelongsTo attribute
    public function attribute()
    {
        return $this->hasMany(Attribute::class);
    }
}
