<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Mail\SuccessBuyComboMail;
use App\Models\Food_combo;
use App\Models\Theater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ComboController extends Controller
{
    public function comboDetails($id)
    {
        $food = Food_combo::find($id);
        if (!$food) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy combo'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'food' => $food
        ]);
    }

    public function refreshTheater(Request $request)
    {
        $theater_id = $request->header('theater_id');
        session()->forget('theater_id');
        session()->forget('cart');

        session()->put('theater_id', $theater_id);
        $foods = Food_combo::where('theater_id', $theater_id)->get();

        $cart = session()->get('cart', []);
        $cartCount = 0;

        return response()->json([
            'status' => 200,
            'foods' => $foods,
            'cartCount' => $cartCount
        ]);
    }

    public function cart(Request $request)
    {
        $cart = session()->get('cart', []);
        $theater_id = $request->header('theater_id');
        $theater = Theater::find($theater_id);
        $user = Auth::user();

        return response()->json([
            'status' => 200,
            'message' => 'Lấy giỏ hàng thành công',
            'cart' => array_values($cart),
            'theater' => $theater,
            'user' => $user,
        ]);
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'food_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'food_name' => 'required|string',
            'food_price' => 'required|numeric',
            'food_image' => 'required|string',
            'food_description' => 'nullable|string',
        ]);

        $foodId = $validated['food_id'];
        $quantity = $validated['quantity'];
        $cart = session()->get('cart', []);

        if (isset($cart[$foodId])) {
            $cart[$foodId]['quantity'] += $quantity;
        } else {
            $cart[$foodId] = [
                'id' => $foodId,
                'name' => $validated['food_name'],
                'quantity' => $quantity,
                'price' => $validated['food_price'],
                'image' => $validated['food_image'],
                'description' => $validated['food_description'],
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => 200,
            'message' => 'Đã thêm combo vào giỏ hàng',
            'cart' => $cart,
        ]);
    }

    public function deleteItemCart(Request $request)
    {
        $id = $request->input('food_id');
        try {
            $cart = session()->get('cart', []);
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Đã xóa combo khỏi giỏ hàng'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting item from cart: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Có lỗi xảy ra khi xóa combo khỏi giỏ hàng'
            ], 500);
        }
    }

    public function updateCart(Request $request)
    {
        $validated = $request->validate([
            'food_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $foodId = $validated['food_id'];
        $quantity = $validated['quantity'];
        $cart = session()->get('cart', []);

        if (isset($cart[$foodId])) {
            if ($quantity <= 0) {
                unset($cart[$foodId]);
            } else {
                $cart[$foodId]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Giỏ hàng đã được cập nhật',
            'cart' => array_values($cart),
        ]);
    }

    public function successBuyCombo(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'totalCost' => 'required|numeric',
            'combos' => 'required|array',
            'combos.*.id' => 'required|integer|exists:foodcombo,id',
            'combos.*.name' => 'required|string',
            'combos.*.quantity' => 'required|integer|min:1',
            'combos.*.price' => 'required|numeric',
        ]);
        $theater_id = $request->header('theater_id');

        $theater = Theater::find($theater_id);
        if (!$theater) {
            Log::error('Theater not found for ID: ' . $validated['theater_id']);
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy cụm rạp',
            ], 404);
        }

        $details = [
            'combos' => $validated['combos'],
            'totalCost' => $validated['totalCost'],
            'date' => $validated['date'],
            'theater_name' => $theater->name,
            'theater_address' => $theater->address,
        ];

        try {
            Mail::to(Auth::user()->email)->send(new SuccessBuyComboMail($details));

            return response()->json([
                'status' => 200,
                'message' => 'Mua hàng thành công! Vui lòng kiểm tra email để xem chi tiết đơn hàng!',
            ]);
        } catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Có lỗi xảy ra khi gửi mail xác nhận mua combo!',
            ], 500);
        }
    }
}
