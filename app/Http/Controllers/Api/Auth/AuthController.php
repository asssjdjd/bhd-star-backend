<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        try {
            $request->validated();

            $user = User::create([
                'surname' => $request->surname,
                'gender' => $request->gender,
                'password' => bcrypt($request->password),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'province' => $request->province,
            ]);
            $token = $user->createToken($user->name)->plainTextToken;

            return response()->json([
                'message' => 'User created successfully',
                'status' => 201,
                'token' => $token,
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Registration failed',
                'status' => 500,
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json([
                'data' => null,
                'status' => 401,
                'message' => 'Email hoặc mật khẩu không chính xác'
            ], 401);
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'data' => null,
                'status' => 401,
                'message' => 'Mật khẩu không chính xác'
            ], 401);
        }

        DB::table('personal_access_tokens')
            ->where('tokenable_id', $user->id)
            ->delete();

        $token = $user->createToken($user->name)->plainTextToken;

        return response()->json([
            'data' => $user,
            'token' => $token,
            'status' => 200,
            'message' => 'Đăng nhập thành công',
            'is_admin' => (bool)$user->is_admin
        ], 200);
    }

    public function logout(Request $request){
        $token = $request->bearerToken();

        DB::table('personal_access_tokens')
            ->where('token', hash('sha256', $token))
            ->delete();
        return response() -> json([
            'status' => 200,
            'message' => 'Đăng xuất thành công'
        ], 200);
    }
}
