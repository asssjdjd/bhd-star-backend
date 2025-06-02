<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FilmController extends Controller
{
    public function index()
    {
        try {
            $films = Film::orderBy('id', 'asc') -> get();
            if($films){
                return response() -> json([
                    'status' => 200,
                    'message' => 'Lấy danh sách phim thành công',
                    'films' => $films
                ], 200);
            }

            return response() -> json([
                'status' => 404,
                'message' => 'Không tìm thấy phim nào',
            ], 404);

        } catch (\Exception $e){
            Log::error('Film get list error: ' . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Không thể lấy danh sách phim'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $film = Film::findOrFail($id);
            return response()->json([
                'status' => 200,
                'message' => 'Lấy thông tin phim thành công',
                'film' => $film
            ], 200);
        } catch (\Exception $e) {
            Log::error('Film show error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Không thể lấy thông tin phim'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {

            $request -> validate([
                'name' => 'required|string',
                'video_link' => 'required|string',
                'images' => 'required|image|max:5120',
                'duration' => 'required|integer',
                'name_director' => 'required|string',
                'name_actor' => 'required|string',
                'description' => 'required|string',
                'type' => 'required|string',
                'launch_date' => 'required|date',
            ]);

            if(!$request -> hasFile('images')){
                return response() -> json([
                    'status' => 400,
                    'message' => 'Vui lòng tải ảnh lên'
                ], 400);
            }

            $uploadedFile = $request->file('images');
            $uploadResult = Cloudinary::upload($uploadedFile->getRealPath(), [
                'folder' => 'films',
            ]);

            if ($uploadResult && $uploadResult->getSecurePath()) {
                $data = $request->except('images');
                $data['images'] = $uploadResult->getSecurePath();
                $data['created_at'] = Carbon::now();
                $film = Film::create($data);

                return response() -> json([
                    'status' => 201,
                    'message' => 'Tạo phim thành công',
                    'film' => $film
                ], 201);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Không thể tải ảnh lên'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Film create error: ' . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Không thể tạo phim'
            ], 500);
        }
    }

    public function update(Request $request){
        try {
            $request -> validate([
                'id' => 'required',
                'name' => 'required|string',
                'video_link' => 'required|string',
                'duration' => 'required|integer',
                'name_director' => 'required|string',
                'name_actor' => 'required|string',
                'description' => 'required|string',
                'type' => 'required|string',
                'launch_date' => 'required|date',
            ]);

            $data = $request -> except('id');

            $film = Film::find($request -> id);

            if(!$film) {
                return response() -> json([
                    'status' => 404,
                    'message' => 'Không tìm thấy phim cần cập nhật'
                ], 404);
            }

            $film -> update($data);

            return response() -> json([
                'status' => 200,
                'message' => 'Cập nhật phim thành công',
                'film' => $film
            ], 200);


        } catch (\Exception $e){
            Log::error('Film update error: ' . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Không thể cập nhật phim'
            ], 500);
        }
    }

    public function delete(Request $request){
        try {
            $request -> validate([
                'id' => 'required'
            ]);

            $film = Film::find($request -> id);

            if(!$film) {
                return response() -> json([
                    'status' => 404,
                    'message' => 'Không tìm thấy phim cần xóa'
                ], 404);
            }

            if($film->images) {
                $url = $film->images;
                $parts = explode('/', parse_url($url, PHP_URL_PATH));
                $filename = end($parts);
                $publicId = 'films/' . pathinfo($filename, PATHINFO_FILENAME);
                Cloudinary::destroy($publicId);
            }

            $film -> delete();

            return response() -> json([
                'status' => 200,
                'message' => 'Xóa phim thành công'
            ], 200);

        } catch (\Exception $e){
            Log::error('Film delete error: ' . $e -> getMessage());
            return response() -> json([
                'status' => 500,
                'message' => 'Không thể xóa phim'
            ], 500);
        }
    }

}
