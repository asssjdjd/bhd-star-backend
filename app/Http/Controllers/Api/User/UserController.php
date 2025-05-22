<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('User.user-detail');
    }

    public function update($id, Request $request){
        $data = $request -> except('_token', 'day', 'month', 'year');
        $day = $request -> input('day');
        $month = $request -> input('month');
        $year = $request -> input('year');
        $date_of_birth = $year . '-' . $month . '-' . $day;
        $data['date_of_birth'] = $date_of_birth;
        $user = User::find($id);
        $user -> update($data); 
        return redirect() -> route('user.detail') -> with('success', 'Update user successfully');
    }
}