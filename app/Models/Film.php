<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = 'film';
    protected $fillable = [
        'name', 
        'video_link', 
        'images', 
        'duration', 
        'name_director', 
        'name_actor', 
        'description', 
        'type',
        'launch_date',
        'created_at'
    ];
}
