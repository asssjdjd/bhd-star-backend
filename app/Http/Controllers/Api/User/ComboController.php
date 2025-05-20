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
        $theater_id = $request->input('theater_id');
        session()->forget('theater_id');
        session()->forget('cart');

        session()->put('theater_id', $theater_id);
        $foods = Food_combo::where('theater_id', $theater_id)->get();

        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'status' => 200,
            'foods' => $foods,
            'cartCount' => $cartCount
        ]);
    }

    public function cart()
    {
        $data = session()->get('cart');
        $theater_id = session()->get('theater_id');
        $theater = Theater::where('id', $theater_id)->first();
        return response()->json([
            'status' => 200,
            'message' => 'Lấy giỏ hàng thành công',
            'cart' => $data,
            'theater' => $theater
        ]);
    }

    public function addToCart(Request $request)
    {
        $foodId = $request->input('food_id');
        $quantity = $request->input('quantity');
        $cart = session()->get('cart');
        if(isset($cart[$foodId])) {
            $cart[$foodId]['quantity'] += $quantity;
        } else {
            $cart[$foodId] = [
                'id' => $foodId,
                "name" => $request->input('food_name'),
                "quantity" => $quantity,
                "price" => $request->input('food_price'),
                "image" => $request->input('food_image'),
                'description' => $request->input('food_description')
            ];
        }

        session()->put('cart', $cart);
        return response()->json([
            'status' => 200,
            'message' => 'Đã thêm combo vào giỏ hàng',
            'cart' => $cart
        ]);
    }

    public function deleteItemCart($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Đã xóa combo khỏi giỏ hàng'
        ]);
    }

     public function successBuyCombo(Request $request)
    {
        try {
            $date = $request->input('date');
            $combos = json_decode($request->input('combos'), true);
            $totalCost = $request->input('totalCost');
            $theater_id = $request->input('theater_id');
            $theater = Theater::find($theater_id);

            if (!$theater) {
                return response()->json(['status' => 404, 'message' => 'Không tìm thấy rạp'], 404);
            }

            $details = [
                'combos' => $combos,
                'totalCost' => $totalCost,
                'date' => $date,
                'theater_name' => $theater->name,
                'theater_address' => $theater->address
            ];

            Mail::to(Auth::user()->email)->send(new SuccessBuyComboMail($details));

            return response()->json([
                'status' => 200,
                'message' => 'Mua hàng thành công! Vui lòng kiểm tra email để xem chi tiết đơn hàng!'
            ]);
        } catch (\Exception $e) {
            Log::error('Combo successBuyCombo error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Có lỗi xảy ra khi gửi mail xác nhận mua combo!',
            ], 500);
        }
    }

}
