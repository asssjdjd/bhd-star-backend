<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food_combo extends Model
{
    protected $table = 'food_combo';
    protected $fillable = [
        'id',
        'name', 
        'price', 
        'image',
        'description', 
        'theater_id',
        'theater_name',
        'created_at'
    ];
}
