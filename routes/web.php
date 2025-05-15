<?php

use App\Http\Controllers\Dev\User\HomeController;
use App\Http\Controllers\Dev\User\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(HomeController::class) -> group(function(){
    Route::get('/', 'index') -> name('home');
    // viet them vao day 
    Route::get('/login', 'login') -> name('login');
});

Route::controller(AdminController::class) -> group(function(){
    Route::get('/admin', 'index') -> name('admin_home');

    // Các route cho các trang quản lý
    Route::get('/admin/category', function () {
        return view('Admin.admin_category');
    })->name('admin_category');

    Route::get('/admin/create-category', function () {
        return view('Admin.admin_create_category');
    })->name('admin_create_category');

    // /admin/film/${id}

    Route::get('/admin/film', function () {
        return view('Admin.admin_film'); // Tạo file admin_film.blade.php
    })->name('admin_film');

    Route::get('admin/showtime/{id}', function () {
        return view('Admin.admin_showtime'); // Tạo file admin_showtime.blade.php
    })->name('admin_showtime'); // Tạo file admin_showtime.blade.php

    Route::get('/admin/foodcombo', function () {
        return view('Admin.admin_foodcombo'); // Tạo file admin_foodcombo.blade.php
    })->name('admin_foodcombo');

    Route::get('/admin/promotion', function () {
        return view('Admin.admin_promotion'); // Tạo file admin_promotion.blade.php
    })->name('admin_promotion');

    Route::get('/admin/theater', function () {
        return view('Admin.admin_theater'); // Tạo file admin_theater.blade.php
    })->name('admin_theater');

});




