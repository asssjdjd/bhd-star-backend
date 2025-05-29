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

    Route::get('/forgot-password', function () {
        return view('User.Auth.forgot-password');
    })->name('forgot_password');

    Route::get('/otp', function () {
        return view('User.Auth.otp');
    })->name('otp');

    Route::get('/reset-password', function () {
        return view('User.Auth.reset-password');
    })->name('reset_password');

    Route::get('/page/{id}', function ($id) {
        return view('User.Film.page', ['id' => $id]);
    })->name('page');

    Route::get('/shop', function () {
        return view('User.shop');
    })->name('shop');

    Route::get('/about-us', function () {
        return view('User.about-us');
    })->name('about_us');

    Route::get('/user-detail', function () {
        return view('User.user-detail');
    })->name('user_detail');

    Route::get('/cart', function () {
        return view('User.Combo.cart');
    })->name('cart');

    Route::get('/combo-detail/{id}', function ($id) {
        return view('User.Combo.combo-detail', ['id' => $id]);
    })->name('combo_detail');

    Route::get('/promotion', function () {
        return view('User.promotion');
    })->name('promotion');

    Route::get('/movie-schedule', function () {
        return view('User.movie-schedule');
    })->name('movie_schedule');

    Route::get('/theater-schedule', function () {
        return view('User.theater-schedule');
    })->name('theater_schedule');

    Route::get('/movie-schedule-detail/{id}', function ($id) {
        return view('User.theater-schedule-detail', ['id' => $id]);
    })->name('movie_schedule_detail');

    Route::get('/theater-system', function () {
        return view('User.theater-system');
    })->name('theater_system');

    Route::get('/theater/{id}', function ($id) {
        return view('User.theater-detail', ['id' => $id]);
    })->name('theater_detail');


    Route::get('/step1/{id}', function ($id) {
        return view('User.Booking.step1', ['id' => $id]);
    })->name('step1');

    Route::get('/step2', function () {
        return view('User.Booking.step2');
    })->name('step2');

    Route::get('/step3', function () {
        return view('User.Booking.step3');
    })->name('step3');

    Route::get('/step4', function () {
        return view('User.Booking.step4');
    })->name('step4');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index')->name('admin_home');

    // Các route cho các trang quản lý

    // category
    Route::get('/admin/category', function () {
        return view('Admin.category.admin_category');
    })->name('admin_category');

    Route::get('/admin/create-category', function () {
        return view('Admin.category.admin_create_category');
    })->name('admin_create_category');

    // /admin/film/${id}

    Route::get('/admin/film', function () {
        return view('Admin.film.admin_film'); // Tạo file admin_film.blade.php
    })->name('admin_film');

    Route::get('admin/showtime/{id}', function () {
        return view('Admin.film.admin_showtime'); // Tạo file admin_showtime.blade.php
    })->name('admin_showtime'); // Tạo file admin_showtime.blade.php

    Route::get('/admin/create-film', function () {
        return view('Admin.film.admin_create_film'); // Tạo file admin_create_film.blade.php
    })->name('admin_create_film');

    Route::get('/admin/edit/{id}', function ($id) {
        return view('Admin.film.admin_edit_film', compact('id')); // Tạo file admin_edit_film.blade.php
    })->name('admin_edit_film');

    // cacs route cua food
    Route::get('admin/foodcombo', function () {
        return view('Admin.FoodCombo.index');
    })->name('admin_foodcombo');

    Route::get('admin/foodcombo/create', function () {
        return view('Admin.FoodCombo.create');
    })->name('admin_create_foodcombo');

    Route::get('admin/foodcombo/{id}', function () {
        return view('Admin.FoodCombo.edit');
    })->name('admin_edit_foodcombo');

    // Các route của promotion
    Route::get('admin/promotion', function () {
        return view('Admin.Promotion.index');
    })->name('admin_promotion');
    Route::get('admin/promotion/create', function () {
        return view('Admin.Promotion.create');
    })->name('admin_create_promotion');
    Route::get('admin/promotion/{id}', function () {
        return view('Admin.Promotion.edit');
    })->name('admin_edit_promotion');

    // Các route của theater
    Route::get('admin/theater', function () {
        return view('Admin.theater.index');
    })->name('admin_theater');
    Route::get('admin/theater/create', function () {
        return view('Admin.theater.create');
    })->name('admin_create_theater');
    Route::get('admin/theater/{id}', function () {
        return view('Admin.theater.edit');
    })->name('admin_edit_theater');
});
