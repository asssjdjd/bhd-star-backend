<?php

namespace App\Http\Controllers\User;
use App\Mail\SuccessBuyComboMail;
use App\Http\Controllers\Controller;
use App\Models\Food_combo;
use App\Models\Theater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ComboController extends Controller
{
    public function comboDetails($id)
    {
        $food = Food_combo::find($id);
        return view('User.Combo.combo-detail', compact('food'));
    }

    public function refeshTheater(Request $request)
    {
        $theater_id = $request->input('theater_id');
        session()->forget('theater_id');
        session()->forget('cart');

        session()->put('theater_id', $theater_id);
        $foods = Food_combo::where('theater_id', $theater_id)->get();

        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'foods' => $foods, 
            'cartCount' => $cartCount
        ]);
    }
    public function cart()
    {
        $data = session()->get('cart');
        $theater_id = session()->get('theater_id');
        $theater = Theater::where('id', $theater_id)->first();
        // dd($data);
        return view('User.Combo.cart', [
            'foods' => $data,
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
        if($request -> input('purchase') == '1') {
            return redirect()->route('cart');
        }
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    public function deleteItemCart($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }

    public function successBuyCombo(Request $request){
        $date = $request->input('date');
        $combos = json_decode($request->input('combos'), true);
        $totalCost = $request->input('totalCost');
        $theater_id = $request->input('theater_id');
        $theater = Theater::where('id', $theater_id)->first();
    
        $details = [
            'combos' => $combos,
            'totalCost' => $totalCost,
            'date' => $date,
            'theater_name' => $theater->name,
            'theater_address' => $theater->address
        ];

        Mail::to(Auth::user()->email)->send(new SuccessBuyComboMail($details));

        return redirect()->route('home')->with('success', 'Mua hàng thành công! Vui lòng kiểm tra email để xem chi tiết đơn hàng!');
    }
}