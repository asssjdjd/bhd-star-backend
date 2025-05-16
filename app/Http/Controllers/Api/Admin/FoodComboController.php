<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food_combo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FoodComboController extends Controller
{
    public function index()
    {
        try {
            $foods = Food_combo::orderBy('id', 'asc')->get();

            if ($foods) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Lấy danh sách combo thành công',
                    'foods' => $foods
                ], 200);
            }

            return response() -> json([
                'status' => 404,
                'message' => 'Không tìm thấy combo nào',
            ], 404);
        } catch (\Exception $e){
            Log::error("FoodCombo get list error: " . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy danh sách combo'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $food = Food_combo::find($id);
            if (!$food) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy combo'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Lấy thông tin combo thành công',
                'food' => $food
            ], 200);
        } catch (\Exception $e) {
            Log::error("FoodCombo get detail error: " . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin combo'
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'image' => 'required|image|max:5120',
                'price' => 'required|integer',
                'description' => 'required|string',
                'theater_id' => 'required|integer',
                'theater_name' => 'required|string'
            ]);

            if (!$request->hasFile('image')) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Vui lòng tải ảnh lên'
                ], 400);
            }

            $image = $request->file('image');

            $data = $request->all();
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

            if(isset($responseData['data']['url'])) {
                $data['image'] = $responseData['data']['url'];
                $food = Food_combo::create($data);

                return response()->json([
                    'status' => 200,
                    'message' => 'Tạo combo thành công',
                    'food' => $food
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error("FoodCombo create error: " . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể tạo combo'
            ], 500);
        }
    }


    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
                'name' => 'required|string',
                'price' => 'required|integer',
                'description' => 'required|string',
                'theater_id' => 'required|integer',
                'theater_name' => 'required|string'
            ]);

           $data = $request->except('id');

           $food = Food_combo::find($request->id);
           if (!$food) {
               return response()->json([
                   'status' => 404,
                   'message' => 'Không tìm thấy combo'
               ], 404);
           }

           $food->update($data);

           return response()->json([
               'status' => 200,
               'message' => 'Cập nhật combo thành công',
               'food' => $food
           ], 200);

        } catch (\Exception $e) {
            Log::error("FoodCombo update error: " . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể cập nhật combo'
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer'
            ]);

            $food = Food_combo::find($request->id);
            if (!$food) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy combo'
                ], 404);
            }

            $food->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Xóa combo thành công'
            ], 200);

        } catch (\Exception $e) {
            Log::error("FoodCombo delete error: " . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể xóa combo'
            ], 500);
        }
    }
}
