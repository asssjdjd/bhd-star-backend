<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function update( Request $request)
    {
        try {
            $data = $request->except('_token', 'day', 'month', 'year');
            $day = $request->input('day');
            $month = $request->input('month');
            $year = $request->input('year');
            $date_of_birth = $year . '-' . $month . '-' . $day;
            $data['date_of_birth'] = $date_of_birth;

            $user = Auth::user();

            User::where('id', $user->id)->update($data);

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thông tin thành công',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Cập nhật thông tin thất bại',
            ], 500);
        }
    }
}
