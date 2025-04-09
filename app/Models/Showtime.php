<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    protected $table = 'showtime';
    protected $fillable = [
        'start_time',
        'film_id',
        'theater_id',
        'created_at',
    ];
}
