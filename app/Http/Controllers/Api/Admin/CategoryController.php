<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::select('id', 'type', 'created_at') -> paginate(10); 

            if($categories){
                return response() -> json([
                    'status' => 200,
                    'message' => 'Lấy danh sách thể loại thành công',
                    'categories' => $categories
                ], 200);
            }

             return response() -> json([
                'status' => 404,
                'message' => 'Không tìm thấy thể loại nào',
            ], 404);
        } catch (\Exception $e){
            Log::error('Category get list error: ' . $e->getMessage());
            return response() -> json([
                'status' => 500,
                'message' => "Lấy danh sách thể loại thất bại",
            ], 500);
        }
        

       
    }

    public function store(Request $request)
    {
        
        try{
            $request -> validate([
                'type' => 'required|string|max:255',
            ]);

            $category = Category::create([
                'type' => $request -> type,
                'created_at' => now(),
            ]);

            return response() -> json([
                'status' => 201,
                'message' => 'Thêm thể loại thành công',
                'category' => $category
            ], 201);

           
        } catch (\Exception $e) {
            Log::error('Category creation error: ' . $e->getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Thêm thể loại thất bại',
            ], 500);
        }
    }

    public function update(Request $request) 
    {
        try {
            $request -> validate([
                'id' => 'required',
                'type' => 'required|string|max:255',
            ]);

            $data = $request -> only(['type']);
            // $data['updated_at'] = Carbon::now();

            $categrory = Category::find($request -> id);

            if(!$categrory) {
                return response() -> json([
                    'status' => 404,
                    'message' => "Không tìm thấy thể loại cần cập nhật"
                ]);
            }

            $categrory -> update($data);

            return response() -> json([
                'status' => 200,
                'message' => 'Cập nhật thể loại thành công',
                'cetegory' => $categrory
            ], 200);

        } catch (\Exception $e){
            Log::error("Category update error: " . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => "Không thể cập nhật thể loại",
            ]); 
        }
    }

    public function delete(Request $request) 
    {
        try {
            $request -> validate([
                'id' => 'required'
            ]);

            $category = Category::find($request -> id);

            if(!$category){
                return response() -> json([
                    'status' => 404,
                    'message' => 'Không tìm thấy thể loại'
                ]);
            }

            $category -> delete();

            return response() -> json([
                'status' => 200,
                'message' => 'Xóa thể loại thành công'
            ], 200);
        } catch (\Exception $e) {
            Log::error("Category delete error: " . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Không thể xóa thể loại'
            ], 500);
        }
    }
}
