<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShowtimeController extends Controller
{
    public function index($film_id)
    {
        try {
            $showtimes = Showtime::where('film_id', $film_id)->orderBy('id', 'asc')->get();
            $film_name = Film::find($film_id)->name;

            foreach ($showtimes as $showtime) {
                $showtime->theater_name = Theater::find($showtime->theater_id)->name;
            }

            if($showtimes) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Lấy danh sách suất chiếu thành công',
                    'showtimes' => $showtimes,
                    'film_name' => $film_name
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy suất chiếu nào',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Showtime get list error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy danh sách suất chiếu'
            ], 500);
        }
    }

    public function store(Request $request, $film_id)
    {
        try {
            $request->validate([
                'film_id' => 'required|integer',
                'start_time' => 'required',
                'theater_id' => 'required|integer'
            ]);

            $showtime = Showtime::create([
                'film_id' => $request->film_id,
                'start_time' => $request->start_time,
                'theater_id' => $request->theater_id
            ]);

            if($showtime) {
                for($char  = ord('A'); $char <= ord('F'); $char++){
                    for($i = 1; $i <= 14; $i++){
                        if($char == ord('D') || $char == ord('E')){
                            if($i > 2 && $i < 13){
                                $seat = new Seat();
                                $seat->row = chr($char); // Thêm giá trị cho cột 'row'
                                $seat->seat_number = $i; // Thêm giá trị cho cột 'seat_number'
                                $seat->showtime_id = $showtime->id;
                                $seat->theater_id = $showtime->theater_id;
                                $seat->type = "Vip";
                                $seat->created_at = Carbon::now();
                                $seat->updated_at = Carbon::now();
                                $seat->save();
                            } else {
                                $seat = new Seat();
                                $seat->row = chr($char); // Thêm giá trị cho cột 'row'
                                $seat->seat_number = $i; // Thêm giá trị cho cột 'seat_number'
                                $seat->showtime_id = $showtime->id;
                                $seat->theater_id = $showtime->theater_id;
                                $seat->type = "Standard";
                                $seat->created_at = Carbon::now();
                                $seat->updated_at = Carbon::now();
                                $seat->save();
                            }
                        } else if($char == ord('F')){
                            if($i % 2 == 0){
                                $seat = new Seat();
                                $seat->row = chr($char); // Thêm giá trị cho cột 'row'
                                $seat->seat_number = $i; // Thêm giá trị cho cột 'seat_number'
                                $seat->showtime_id = $showtime->id;
                                $seat->theater_id = $showtime->theater_id;
                                $seat->type = "Couple";
                                $seat->created_at = Carbon::now();
                                $seat->updated_at = Carbon::now();
                                $seat->save();
                            }
                        } else {
                            $seat = new Seat();
                            $seat->row = chr($char); // Thêm giá trị cho cột 'row'
                            $seat->seat_number = $i; // Thêm giá trị cho cột 'seat_number'
                            $seat->showtime_id = $showtime->id;
                            $seat->theater_id = $showtime->theater_id;
                            $seat->type = "Standard";
                            $seat->created_at = Carbon::now();
                            $seat->updated_at = Carbon::now();
                            $seat->save();
                        }

                    }
                }

                $film = Film::find($request->film_id);
                if($film){
                    $startDate = Carbon::parse(substr($request -> start_time, 0, 10));
                    if($film->launch_date != null){
                        $launchDate = Carbon::parse($film->launch_date);
                        if($launchDate->gt($startDate)){
                            $film->launch_date = $startDate->toDateString();
                            $film->save();
                        }
                    } else {
                        $film->launch_date = $startDate->toDateString();
                        $film->save();
                    }
                }
            }

            return response()->json([
                'status' => 201,
                'message' => 'Thêm suất chiếu thành công',
                'showtime' => $showtime
            ], 201);
        } catch (\Exception $e) {
            Log::error('Showtime create error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể thêm suất chiếu'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
                'start_time' => 'required',
                'theater_id' => 'required|integer'
            ]);

            $showtime = Showtime::find($request->id);
            if (!$showtime) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy suất chiếu'
                ], 404);
            }

            $showtime->update([
                'start_time' => $request->start_time,
                'theater_id' => $request->theater_id
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật suất chiếu thành công',
                'showtime' => $showtime
            ], 200);
        } catch (\Exception $e) {
            Log::error('Showtime update error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể cập nhật suất chiếu'
            ], 500);
        }
    }


    public function delete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer'
            ]);

            $showtime = Showtime::find($request->id);
            if (!$showtime) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy suất chiếu'
                ], 404);
            }

            $showtime->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Xóa suất chiếu thành công'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Showtime delete error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể xóa suất chiếu'
            ], 500);
        }
    }
}
