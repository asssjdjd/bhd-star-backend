<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $table = 'seat';
    protected $fillable = [
        'row',
        'seat_number',
        'type',
        'status',
        'created_at',
        'updated_at',
    ];
}