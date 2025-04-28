<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TheaterController extends Controller
{
    public function index()
    {
        try {
            $theaters = Theater::orderBy('id', 'asc')->get();

            if ($theaters) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Lấy danh sách rạp phim thành công',
                    'theaters' => $theaters
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy rạp phim nào',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Theater get list error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy danh sách rạp phim'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request -> validate([
                'name' => 'required|string',
                'address' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|string',
                'policy' => 'required|string',
                'image' => 'required|image|max:5120',
            ]);

            if(!$request -> hasFile('image')){
                return response() -> json([
                    'status' => 400,
                    'message' => 'Vui lòng tải ảnh lên'
                ], 400);
            }

            $data = $request -> all();
            $data['created_at'] = Carbon::now();

            $image = $request -> file('image');
            $imageData = base64_encode(file_get_contents($image -> getRealPath()));

            $apikey = env('IMGBB_API_KEY');
            $url = 'https://api.imgbb.com/1/upload?key=' . $apikey;

            $response = Http::asForm()->post($url, [
                'image' => $imageData,
            ]);



            $responseData = $response->json();
            if (isset($responseData['data']['display_url'])) {
                // Lưu link ảnh vào database
                $data['image'] = $responseData['data']['display_url'];
                $theater = Theater::create($data);
    
                return response() -> json([
                    'status' => 201,
                    'message' => 'Tạo rạp phim thành công',
                    'theater' => $theater
                ], 201);
            }

        } catch (\Exception $e) {
            Log::error('Theater create error: ' . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Không thể tạo rạp phim'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try{
            $request -> validate([
                'id' => 'required',
                'name' => 'required|string',
                'address' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|string',
                'policy' => 'required|string',
            ]);

            $data = $request -> except('id');

            $theater = Theater::find($request -> id);

            if(!$theater) {
                return response() -> json([
                    'status' => 404,
                    'message' => 'Không tìm thấy rạp phim cần cập nhật'
                ], 404);
            }

            $theater -> update($data);

            return response() -> json([
                'status' => 200,
                'message' => 'Cập nhật rạp phim thành công',
                'theater' => $theater
            ], 200);

        
        } catch (\Exception $e){
            Log::error('Theater update error: ' . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Không thể cập nhật rạp phim'
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try{
            $request -> validate([
                'id' => 'required'
            ]);

            $theater = Theater::find($request -> id);

            if(!$theater) {
                return response() -> json([
                    'status' => 404,
                    'message' => 'Không tìm thấy rạp phim cần xóa'
                ], 404);
            }

            $theater -> delete();

            return response() -> json([
                'status' => 200,
                'message' => 'Xóa rạp phim thành công'
            ], 200);

        } catch (\Exception $e){
            Log::error('Theater delete error: ' . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Không thể xóa rạp phim'
            ], 500);
        }
    }
}
