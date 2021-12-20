<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'id',
        'name', 
        'short_name', 
        'slug',
        'phone', 
        'address', 
        'email',
        'country',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_email',
        'status',
        'created_at',
        'updated_at',
        'logo',
    ];
}
