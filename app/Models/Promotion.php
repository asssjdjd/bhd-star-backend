<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotion';
    protected $fillable = [
        'id', 
        'title', 
        'link',
        'image',
        'discount', 
        'description',
        'discount_type', 
        'discount_value',   
        'created_at'
    ];
}
