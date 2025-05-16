<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PromotionController extends Controller
{
    public function index()
    {
        try {
            $promotions = Promotion::orderBy('id', 'asc')->get();
    
            if ($promotions) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Lấy danh sách khuyến mãi thành công',
                    'promotions' => $promotions
                ], 200);
            }
    
            return response() -> json([
                'status' => 404,
                'message' => 'Không tìm thấy khuyến mãi nào',
            ], 404);
        } catch (\Exception $e){
            Log::error("Promotion get list error: " . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy danh sách khuyến mãi'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $promotion = Promotion::find($id);

            if(!$promotion) {
                return response() -> json([
                    'status' => 404,
                    'message' => 'Không tìm thấy khuyến mãi'
                ], 404);
            }

            return response() -> json([
                'status' => 200,
                'message' => 'Lấy thông tin khuyến mãi thành công',
                'promotion' => $promotion
            ], 200);

        } catch (\Exception $e){
            Log::error('Promotion get error: ' . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin khuyến mãi'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'image' => 'required|image|max:5120',
                'discount' => 'required|date',
                'description' => 'required|string',
                'discount_type' => 'required|string',
                'discount_value' => 'required|integer'
            ]);

            if (!$request->hasFile('image')) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Vui lòng tải ảnh lên'
                ], 400);
            }

            $image = $request->file('image');

            $data = $request -> all();
            $data['created_at'] = Carbon::now();
            $imageData = base64_encode(file_get_contents($image -> getRealPath()));

            $apikey = env('IMGBB_API_KEY');
            $url = 'https://api.imgbb.com/1/upload?key=' . $apikey;

            $response = Http::withOptions([
                'verify' => env('CURL_CERT')
            ])->asForm()->post($url, [
                'image' => $imageData
            ]);



            $responseData = $response->json();
            if (isset($responseData['data']['display_url'])) {
                // Lưu link ảnh vào database
                $data['image'] = $responseData['data']['display_url'];
                $promotion = Promotion::create($data);
    
                return response() -> json([
                    'status' => 201,
                    'message' => 'Tạo khuyến mại thành công',
                    'promotion' => $promotion
                ], 201);
            }
           
        } catch (\Exception $e) {
            Log::error("Promotion create error: " . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => "Không thể tạo khuyến mãi"
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try{
            $request -> validate([
                'id' => 'required',
                'title' => 'required|string',
                'discount' => 'required|date',
                'description' => 'required|string',
                'discount_type' => 'required|string',
                'discount_value' => 'required|integer'
            ]);

            $data = $request -> except('id');

            $promotion = Promotion::find($request -> id);

            if(!$promotion) {
                return response() -> json([
                    'status' => 404,
                    'message' => 'Không tìm thấy khuyến mãi cần cập nhật'
                ], 404);
            }

            $promotion -> update($data);

            return response() -> json([
                'status' => 200,
                'message' => 'Cập nhật khuyến mãi thành công',
                'promotion' => $promotion
            ], 200);

        
        } catch (\Exception $e){
            Log::error('Promotion update error: ' . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Không thể cập nhật khuyến mãi'
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $request -> validate([
                'id' => 'required'
            ]);

            $promotion = Promotion::find($request -> id);

            if(!$promotion) {
                return response() -> json([
                    'status' => 404,
                    'message' => 'Không tìm thấy khuyến mãi cần xóa'
                ], 404);
            }

            $promotion -> delete();

            return response() -> json([
                'status' => 200,
                'message' => 'Xóa khuyến mãi thành công'
            ], 200);

        } catch (\Exception $e){
            Log::error('Promotion delete error: ' . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Không thể xóa khuyến mãi'
            ], 500);
        }
    }
}
