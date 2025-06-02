<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food_combo;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FoodComboController extends Controller
{
    public function index()
    {
        try {
            $foods = Food_combo::orderBy('id', 'asc')->get();

            foreach($foods as $food) {
                $food->theater_name = Theater::where('id', $food->theater_id)->value('name');
            }
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
            ]);

            if (!$request->hasFile('image')) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Vui lòng tải ảnh lên'
                ], 400);
            }


            $uploadedFile = $request->file('image');
            $uploadResult = Cloudinary::upload($uploadedFile->getRealPath(), [
                'folder' => 'food_combos'
            ]);

            if ($uploadResult && $uploadResult->getSecurePath()) {
                $data = $request->except('image');
                $data['image'] = $uploadResult->getSecurePath();
                $food = Food_combo::create($data);

                return response()->json([
                    'status' => 200,
                    'message' => 'Tạo combo thành công',
                    'food' => $food
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Không thể upload ảnh lên Cloudinary'
                ], 500);
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

            if ($food->image) {
                $url = $food->image;
                $parts = explode('/', parse_url($url, PHP_URL_PATH));
                $filename = end($parts);
                $publicId = 'food_combos/' . pathinfo($filename, PATHINFO_FILENAME);

                Cloudinary::destroy($publicId);
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
