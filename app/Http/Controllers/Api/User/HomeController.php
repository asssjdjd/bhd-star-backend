<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Film;
use App\Models\Food_combo;
use App\Models\Promotion;
use App\Models\Showtime;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try{
            $today = Carbon::now()->format('Y-m-d');
            $futureDate = Carbon::now()->copy()->addDays(14)->format('Y-m-d');
            $pastDate = Carbon::now()->copy()->subDays(30 * 3)->format('Y-m-d');


            $films = Film::where('launch_date', '>=', $pastDate)
                         ->where('launch_date', '<=', $futureDate)
                         ->orderByDesc('id')
                         ->limit(20)
                         ->get();

            foreach($films as $film){
                $film->type_name = Category::find($film->type)->type;
            }

            $commingSoon = [];
            foreach(Film::all() as $film){
                if ($film->launch_date > $futureDate) {
                    $commingSoon[] = $film;
                }
            }

            if($commingSoon){
                foreach($commingSoon as $film){
                    $film->type_name = Category::find($film->type)->type;
                }
            }

            if($films || $commingSoon){
                return response()->json([
                    'status' => 200,
                    'message' => 'Lấy danh sách phim thành công',
                    'films' => $films,
                    'commingSoon' => $commingSoon
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy phim nào',
            ], 404);
        } catch (\Exception $e) {
            Log::error('HomeController get list error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy danh sách phim'
            ], 500);
        }
    }

    public function getPromotion(){
        try{
            $promotions = Promotion::orderByDesc('id')
                                -> paginate(10);

            if($promotions){
                return response()->json([
                    'status' => 200,
                    'message' => 'Lấy danh sách khuyến mãi thành công',
                    'promotions' => $promotions
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy khuyến mãi nào',
            ], 404);
        } catch (\Exception $e) {
            Log::error('HomeController get list error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy danh sách khuyến mãi'
            ], 500);
        }
    }

    public function getTheaterSystem(){
        try{
            $theaters = Theater::orderByDesc('id')
                                -> paginate(10);

            if($theaters){
                return response()->json([
                    'status' => 200,
                    'message' => 'Lấy danh sách rạp thành công',
                    'theaters' => $theaters
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy rạp nào',
            ], 404);
        } catch (\Exception $e) {
            Log::error('HomeController get list error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy danh sách rạp'
            ], 500);
        }
    }

    public function getShop(){
        try {
            $theaters = Theater::select('id', 'name', 'address')
                            ->get();

            $theater_id = min($theaters->pluck('id')->toArray());

            session()->put('theater_id', $theater_id);
            $foods = Food_combo::where('theater_id', $theater_id)
                                ->get();
            $cartCount = session()->get('cart', []) ?? 0;
            if($theaters && $foods){
                return response()->json([
                    'status' => 200,
                    'message' => 'Lấy danh sách rạp và combo thành công',
                    'theaters' => $theaters,
                    'foods' => $foods,
                    'theater_id' => session() -> get('theater_id'),
                    'cart_count' => count($cartCount)
                ], 200);
            }
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy rạp hoặc combo nào',
            ], 404);
        } catch (\Exception $e) {
            Log::error('HomeController get list error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin về food combo và rạp'
            ], 500);
        }
    }

    public function getTheaterSchedule(){
        try {
            $today = Carbon::now()->format('Y-m-d');
            $showtimes = Showtime::whereDate('start_time', $today)
                                ->orderBy('start_time')
                                ->get();
            $theaters = [];

            foreach($showtimes as $showtime){
                $theater = Theater::find($showtime->theater_id);
                if(in_array($theater, $theaters)){
                    continue;
                }
                $theaters[] = $theater;
            }

            if($theaters){
                return response()->json([
                    'status' => 200,
                    'message' => 'Lấy lịch chiếu rạp thành công',
                    'theaters' => $theaters,
                    'showtimes' => $showtimes
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy lịch chiếu nào',
            ], 404);
        } catch (\Exception $e) {
            Log::error('HomeController get list error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin về lịch chiếu'
            ], 500);
        }
    }

    public function getTheaterDetail($id){
        try {
            $theaters = Theater::all();
            $theater = null;

            foreach($theaters as $item){
                if($id == $item -> id){
                    $theater = $item;
                    break;
                }
            }

            return response()->json([
                'status' => 200,
                'message' => 'Lấy thông tin rạp thành công',
                'theater' => $theater,
                'theaters' => $theaters
            ], 200);
        } catch (\Exception $e) {
            Log::error('HomeController get list error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin về rạp'
            ], 500);
        }
    }

    public function getMovieSchedule(){
        try {
            $today = Carbon::now()->format('Y-m-d');
            $futureDate = Carbon::now()->copy()->addDays(14)->format('Y-m-d');
            $lastDate = Carbon::now()->copy()->subDays(30)->format('Y-m-d');

            $films = Film::where('launch_date', '>=', $lastDate)
                        ->where('launch_date', '<=', $futureDate)
                        ->orderByDesc('id')
                        ->limit(15)
                        ->get();

            foreach($films as $film){
                $film->type_name = Category::find($film->type)->type;
            }

            $commingSoon = [];
            foreach(Film::all() as $film){
                if ($film->launch_date > $futureDate) {
                    $commingSoon[] = $film;
                }
            }

            if($films || $commingSoon ){
                return response()->json([
                    'status' => 200,
                    'message' => 'Lấy lịch chiếu phim thành công',
                    'films' => $films,
                    'commingSoon' => $commingSoon
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy lịch chiếu nào',
            ], 404);

        } catch (\Exception $e) {
            Log::error('HomeController get list error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin về lịch chiếu'
            ], 500);
        }
    }

    public function getTheaterScheduleDetail($id){
        try {
            $theater = Theater::find($id);
            $today = Carbon::now()->format('Y-m-d');
            $showtimes = Showtime::where('theater_id', $id)
                                ->whereDate('start_time', $today)
                                ->orderBy('start_time')
                                ->get();

            $films = [];
            foreach($showtimes as $showtime){
                $film = Film::find($showtime->film_id);
                if(in_array($film, $films)){
                    continue;
                }
                $films[] = $film;
            }

            return response()->json([
                'status' => 200,
                'message' => 'Lấy lịch chiếu rạp thành công',
                'theater' => $theater,
                'films' => $films,
                'showtimes' => $showtimes
            ]);
        } catch (\Exception $e) {
            Log::error('HomeController get list error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin về lịch chiếu'
            ], 500);
        }
    }

}
