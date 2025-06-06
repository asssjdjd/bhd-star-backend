<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Mail\SuccessBookingMail;
use App\Models\Category;
use App\Models\Film;
use App\Models\Food_combo;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function step1($id)
    {
        try{
            $film = Film::where('id', $id) -> first();
            $film -> category_name = Category::find($film->type)->type;
            $today = Carbon::now()->toDateString();
            $fifteenMinutesAgo = Carbon::now()->subMinutes(15);
            $showtimes = Showtime::where('film_id', $id)
                ->whereDate('start_time', $today)
                ->where('start_time', '>', $fifteenMinutesAgo)
                ->orderBy('start_time', 'asc')
                ->get();
            $theaters = [];
            if($showtimes -> isEmpty())
            {
                $showtimes = "empty";
            } else {
                foreach($showtimes as $item){
                    $tmp = Theater::where('id', $item->theater_id)->first();
                    if(!in_array($tmp, $theaters)){
                        $theaters[] = $tmp;
                    }
                }
            }

            return response()->json([
                'status' => 200,
                'message' => 'Lấy thông tin bước 1 thành công',
                'film' => $film,
                'showtimes' => $showtimes,
                'theaters' => $theaters
            ], 200);

        } catch (\Exception $e) {
            Log::error('TicketController step1 error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin cho bước 1'
            ], 500);
        }
    }

    public function senday(Request $request)
    {
        try {
            $dateInput = $request->input('date'); // Ngày người dùng chọn
            $filmId = $request->input('film_id');

            // Validate đầu vào cơ bản
            if (!$dateInput || !$filmId) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Thiếu thông tin ngày hoặc ID phim.'
                ], 400);
            }

            $parsedDate = Carbon::parse($dateInput)->startOfDay(); // Chuẩn hóa ngày người dùng chọn về đầu ngày
            $today = Carbon::now()->startOfDay(); // Ngày hôm nay, đầu ngày (đã theo múi giờ config)

            // 1. Kiểm tra nếu ngày được gửi lên là một ngày trong quá khứ
            if ($parsedDate->lt($today)) {
                return response()->json([
                    'showtimes' => [],
                    'theaters' => []
                ]);
            }

            // 2. Lấy tất cả các suất chiếu của phim trong ngày được chọn
            $allShowtimesForDate = Showtime::where('film_id', $filmId)
                                        ->whereDate('start_time', $parsedDate->toDateString())
                                        ->orderBy('start_time', 'asc')
                                        ->get();

            $showtimes = $allShowtimesForDate; // Gán giá trị ban đầu

            // 3. Nếu ngày được chọn là ngày hôm nay, lọc lại danh sách $showtimes
            if ($parsedDate->isSameDay($today)) {
                $fifteenMinutesAgo = Carbon::now()->subMinutes(15); // Thời điểm hiện tại - 15 phút

                // Lọc collection: chỉ giữ lại những suất chiếu có start_time > $fifteenMinutesAgo
                $showtimes = $allShowtimesForDate->filter(function ($showtime) use ($fifteenMinutesAgo) {
                    return Carbon::parse($showtime->start_time)->gt($fifteenMinutesAgo);
                })->values(); // ->values() để reset keys của collection sau khi filter
            }
            // Nếu là ngày trong tương lai, $showtimes sẽ giữ nguyên giá trị của $allShowtimesForDate

            $theaters = [];
            if (!$showtimes->isEmpty()) {
                // Lấy danh sách các theater_id duy nhất từ các showtimes đã lọc (hoặc chưa lọc)
                $theaterIds = $showtimes->pluck('theater_id')->unique()->filter()->values();
                if ($theaterIds->isNotEmpty()) {
                    $theaters = Theater::whereIn('id', $theaterIds)->get();
                }
            }

            return response()->json([
                'showtimes' => $showtimes,
                'theaters' => $theaters
            ]);

        } catch (\Exception $e) {
            Log::error('TicketController senday error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin cho bước 2'
            ], 500);
        }
    }

    public function sendayTheater(Request $request)
    {
        try {
            $date = $request->input('date');
            $theaterId = $request->input('theater_id');
            $today = Carbon::now()->toDateString();

            // Kiểm tra nếu ngày được gửi lên là trước ngày hôm nay
            if (Carbon::parse($date)->lt(Carbon::parse($today))) {
                return response()->json([
                    'showtime' => [],
                    'films' => [],
                    'theaterName' => ''
                ]);
            }

            // Nếu ngày được gửi lên là sau ngày hôm nay, thực hiện truy vấn
            $films = [];
            $showtime = Showtime::where('theater_id', $theaterId)->whereDate('start_time', $date)->get();
            foreach($showtime as $item){
                $tmp = Film::where('id', $item->film_id)->first();
                if(!in_array($tmp, $films)){
                    $films[] = $tmp;
                }
            }
            return response()->json([
                'showtime' => $showtime,
                'films' => $films,
                'theaterName' => Theater::where('id', $theaterId)->first()->name
            ]);

        } catch (\Exception $e) {
            Log::error('TicketController senday error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin cho bước 2'
            ], 500);
        }
    }

    public function step2(Request $request)
    {
        try{
            $theater_id = $request->input('theater_id');
            $showtime_id = $request->input('showtime_id');
            $film_id = $request->input('film_id');

            $seats = Seat::where('theater_id', $theater_id)
                        ->where('showtime_id', $showtime_id)
                        ->get();


            // Chuẩn bị dữ liệu để truyền sang view
            $soldSeats = [];
            foreach($seats as $seat){
                if($seat->status == "Sold"){
                    $soldSeats[] = $seat->row . $seat->seat_number;
                }
            }


            $vipSeats = [];
            foreach($seats as $seat){
                if($seat->type == "VIP"){
                    $vipSeats[] = $seat->row . $seat->seat_number;
                }
            }

            $coupleSeats = [];
            foreach($seats as $seat){
                if($seat->type == "Couple"){
                    $coupleSeats[] = $seat->row . $seat->seat_number;
                }
            }

            $film = Film::where('id', $film_id) -> first();

            return response()->json([
                'status' => 200,
                'message' => 'Lấy thông tin bước 2 thành công',
                'seats' => $seats,
                'soldSeats' => $soldSeats,
                'vipSeats' => $vipSeats,
                'coupleSeats' => $coupleSeats,
                'film' => $film
            ], 200);

        } catch (\Exception $e) {
            Log::error('TicketController step2 error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin cho bước 2'
            ], 500);
        }
    }

    public function step3(Request $request)
    {
        try{
            $theater_id = $request->input('theaterId');
            $showtime_id = $request->input('showtimeId');
            $film_id = $request->input('filmId');
            $selectedSeats = explode(',', $request->query('selectedSeats'));
            $totalCost = $request->query('totalCost');

            $food_combos = Food_combo::where('theater_id', $theater_id)->get();
            $film_name = Film::where('id', $film_id)->first()->name;
            $theater_name = Theater::where('id', $theater_id)->first()->name;
            $showtime = Showtime::where('id', $showtime_id)->first();

            return response()->json([
                'status' => 200,
                'message' => 'Lấy thông tin bước 3 thành công',
                'selectedSeats' => $selectedSeats,
                'totalCost' => $totalCost,
                'food_combos' => $food_combos,
                'showtimeId' => $showtime_id,
                'theaterId' => $theater_id,
                'filmId' => $film_id,
                'film_name' => $film_name,
                'theater_name' => $theater_name,
                'showtime' => $showtime
            ], 200);

        } catch (\Exception $e) {
            Log::error('TicketController getSeat error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin ghế'
            ], 500);
        }
    }

    public function step4(Request $request){
        try{
            $theater_id = $request->input('theaterId');
            $showtime_id = $request->input('showtimeId');
            $film_id = $request->input('filmId');
            $selectedSeats = explode(',', $request->query('selectedSeats'));
            $totalCost = $request->query('totalCost');
            $combos = $request->query('combo', []);

            $film_name = Film::where('id', $film_id)->first()->name;
            $theater_name = Theater::where('id', $theater_id)->first()->name;
            $showtime = Showtime::where('id', $showtime_id)->first();
            return response()->json([
                'status' => 200,
                'message' => 'Lấy thông tin bước 4 thành công',
                'selectedSeats' => $selectedSeats,
                'totalCost' => $totalCost,
                'showtimeId' => $showtime_id,
                'theaterId' => $theater_id,
                'filmId' => $film_id,
                'film_name' => $film_name,
                'theater_name' => $theater_name,
                'showtime' => $showtime,
                'combos' => $combos
            ], 200);
        } catch (\Exception $e) {
            Log::error('TicketController step4 error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin bước 4'
            ], 500);
        }
    }

    public function sendSuccessBookingMail(Request $request){
        try {
            $theater_id = $request->input('theaterId');
            $showtime_id = $request->input('showtimeId');
            $film_id = $request->input('filmId');
            $selectedSeats = $request->input('selectedSeats', []);
            $totalCost = $request->input('totalCost');
            $combos = $request->input('combos');

            // Chuyển đổi mảng combo từ id => value sang name => value
            $food_combos = [];
            foreach ($combos as $id => $quantity) {
                $name = Food_combo::where('id', $id)->first()->name;
                $food_combos[] = [
                    'name' => $name,
                    'quantity' => $quantity
                ];
            }


            $film_name = Film::where('id', $film_id)->first()->name;
            $theater_name = Theater::where('id', $theater_id)->first()->name;
            $theater_address = Theater::where('id', $theater_id)->first()->address;
            $showtime = Showtime::where('id', $showtime_id)->first();

            $details = [
                'film_name' => $film_name,
                'theater_name' => $theater_name,
                'theater_address' => $theater_address,
                'start_time' => $showtime -> start_time,
                'selectedSeats' => $selectedSeats,
                'totalCost' => $totalCost,
                'combos' => $food_combos
            ];


            Mail::to(Auth::user() -> email)->send(new SuccessBookingMail($details));
            $seat = Seat::where('theater_id', $theater_id)
                        ->where('showtime_id', $showtime_id)
                        ->get();

            foreach($seat as $item){
                if(in_array($item->row . $item->seat_number, $selectedSeats)){
                    $item->status = "Sold";
                    $item->save();
                }
            }
            return response()->json([
                'status' => 200,
                'message' => 'Gửi email xác nhận thành công'
            ], 200);
        } catch (\Exception $e) {
            Log::error('TicketController sendSuccessBookingMail error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể gửi email xác nhận'
            ], 500);
        }

    }
}
