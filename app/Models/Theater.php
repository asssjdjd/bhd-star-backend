<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    protected $table = "theater";
    protected $fillable = [
        'name',
        'address',	
        'phone',
        'email'	,
        'policy',
        'image'	,
        'created_at',	
    ];
}
