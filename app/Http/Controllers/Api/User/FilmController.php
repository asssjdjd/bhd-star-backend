<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilmController extends Controller
{
    public function getFilm($id){
        try{
            $film = Film::find($id);
            if($film){
                return response()->json([
                    'status' => 200,
                    'message' => 'Lấy thông tin phim thành công',
                    'film' => $film
                ], 200);
            }
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy phim nào',
            ], 404);
        } catch (\Exception $e) {
            Log::error('FilmController get film error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin phim'
            ], 500);
        }
    }
}
