<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function getFilm($id){
        $film = Film::find($id);
        $film -> type_name = Category::find($film -> type) -> type;
        return view('User.Film.page', ['film' => $film]);
    }
}