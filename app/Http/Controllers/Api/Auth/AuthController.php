<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

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

    public function sendResetLink(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|email',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'message' => 'Email không tồn tại',
                    'status' => 404,
                ], 404);
            }

            Session::forget(['otp', 'email']);

            $otp = rand(100000, 999999);
            Session::put('otp', $otp);
            Session::put('email', $request->email);

            // Send OTP email
            Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Mã OTP đặt lại mật khẩu');
            });

            return response()->json([
                'message' => 'Mã OTP đã được gửi đến email của bạn',
                'status' => 200,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Send reset link error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Lỗi khi gửi liên kết đặt lại mật khẩu',
                'status' => 500,
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required|numeric',
            ]);

            $sessionOtp = Session::get('otp');
            $email = Session::get('email');

            if ($request->otp != $sessionOtp) {
                return response()->json([
                    'message' => 'Mã OTP không chính xác',
                    'status' => 400,
                ], 400);
            }

            return response()->json([
                'message' => 'Mã OTP xác thực thành công',
                'status' => 200,
                'email' => $email,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Verify OTP error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Lỗi khi xác thực mã OTP',
                'status' => 500,
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $user = User::where('email', Session::get('email'))->first();

            if (Hash::check($request->password, $user->password)) {
                return back()->with('error', 'Mật khẩu mới không được trùng với mật khẩu cũ');
            }

            $user->password = bcrypt($request->password);
            $user->save();

            Session::forget(['otp', 'email']);

            return response()->json([
                'message' => 'Mật khẩu đã được đặt lại thành công',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Reset password error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Lỗi khi đặt lại mật khẩu',
                'status' => 500,
            ], 500);
        }
    }
}
