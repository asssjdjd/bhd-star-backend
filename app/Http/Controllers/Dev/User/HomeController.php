<?php

namespace App\Http\Controllers\Dev\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index()
   {
      return view('User.home');
   }
}
