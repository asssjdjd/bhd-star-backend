<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'gender' => 'required|in:0,1,2',
                'province' => 'nullable|string|max:255',
                'day' => 'required|integer|min:1|max:31',
                'month' => 'required|integer|min:1|max:12',
                'year' => 'required|integer|min:1900|max:' . date('Y'),
            ]);

            $date_of_birth = sprintf('%04d-%02d-%02d', $validated['year'], $validated['month'], $validated['day']);

            $user = $request->user();

            $user->update([
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'phone' => $validated['phone'] ?? null,
                'gender' => $validated['gender'],
                'province' => $validated['province'] ?? null,
                'date_of_birth' => $date_of_birth,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thông tin thành công',
                'data' => [
                    'user' => $user,
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating user information: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'input' => $request->all(),
            ]);
            return response()->json([
                'status' => 500,
                'message' => 'Cập nhật thông tin thất bại',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
