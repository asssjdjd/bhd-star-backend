<?php

use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\FilmController;
use App\Http\Controllers\Api\Admin\FoodComboController;
use App\Http\Controllers\Api\Admin\PromotionController;
use App\Http\Controllers\Api\Admin\ShowtimeController;
use App\Http\Controllers\Api\Admin\TheaterController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\FilmController as UserFilmController;
use App\Http\Controllers\Api\User\HomeController;
use App\Http\Controllers\Api\User\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Auth routes */
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');


/* Admin routes */
Route::middleware('auth:sanctum', 'auth.admin') -> group(function () {
    Route::controller(CategoryController::class) -> group(function(){
        Route::get('/admin/category', 'index') -> name('admin.category.index');
        Route::post('/admin/category/create', 'store') -> name('admin.category.create');
        Route::put('/admin/category/update', 'update') -> name('admin.category.update');
        Route::delete('/admin/category/delete', 'delete') -> name('admin.category.delete');
    });

    Route::controller(FilmController::class) -> group(function(){
        Route::get('admin/film/index', 'index') -> name('admin.film.index');
        Route::post('admin/film/create', 'store') -> name('admin.film.create');
        Route::put('admin/film/update', 'update') -> name('admin.film.update');
        Route::delete('admin/film/delete', 'delete') -> name('admin.film.delete');
    });

    Route::controller(PromotionController::class) -> group(function(){
        Route::get('admin/promotion/index', 'index') -> name('admin.promotion.index');
        Route::post('admin/promotion/create', 'store') -> name('admin.promotion.create');
        Route::get('admin/promotion/{id}', 'show')->name('admin.promotion.edit');
        Route::put('admin/promotion/update', 'update') -> name('admin.promotion.update');
        Route::delete('admin/promotion/delete', 'delete') -> name('admin.promotion.delete');
    });

    Route::controller(TheaterController::class) -> group(function(){
        Route::get('admin/theater/index', 'index') -> name('admin.theater.index');
        Route::post('admin/theater/create', 'store') -> name('admin.theater.create');
        Route::get('admin/theater/{id}', 'show')->name('admin.theater.edit');
        Route::put('admin/theater/update', 'update') -> name('admin.theater.update');
        Route::delete('admin/theater/delete', 'delete') -> name('admin.theater.delete');
    });

    Route::controller(FoodComboController::class) -> group(function(){
        Route::get('admin/food-combo/index', 'index') -> name('admin.food-combo.index');
        Route::post('admin/food-combo/create', 'store') -> name('admin.food-combo.create');
        Route::get('admin/food-combo/{id}', 'show')->name('admin.food-combo.edit');
        Route::put('admin/food-combo/update', 'update') -> name('admin.food-combo.update');
        Route::delete('admin/food-combo/delete', 'delete') -> name('admin.food-combo.delete');
    });

    Route::controller(ShowtimeController::class) -> group(function(){
        Route::get('admin/showtime/index/{film_id}', 'index') -> name('admin.showtime.index');
        Route::post('admin/showtime/create/{film_id}', 'store') -> name('admin.showtime.create');
        Route::put('admin/showtime/update', 'update') -> name('admin.showtime.update');
        Route::delete('admin/showtime/delete', 'delete') -> name('admin.showtime.delete');
    });
});

/* User routes (public) */
Route::prefix('/user') -> group(function () {
    Route::controller(HomeController::class) -> group(function(){
        Route::get('/index', 'index') -> name('user.index');
        Route::get('/shop', 'getShop') -> name('user.getShop');
        Route::get('/theater-system', 'getTheaterSystem') -> name('user.get-theater-system');
        Route::get('/theater-schedule', 'getTheaterSchedule') -> name('user.get-theater-schedule');
        Route::get('/movie-schedule', 'getMovieSchedule') -> name('user.get-movie-schedule');
    });
    Route::controller(UserFilmController::class) -> group(function(){
        Route::get('/film/{id}', 'getFilm') -> name('user.getFilm');
    });
    Route::controller(TicketController::class) -> group(function(){
        Route::get('/step1/{id}', 'step1') -> name('user.ticket.step1');
        Route::post('/senday', 'senday') -> name('user.ticket.senday');
    });
});

Route::middleware('auth:sanctum')->group(function() {
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User authenticated routes
    Route::prefix('/user')->group(function() {
        Route::controller(TicketController::class)->group(function(){
            Route::post('/step2', 'step2') -> name('user.ticket.step2');
            Route::post('/step3', 'step3') -> name('user.ticket.step3');
        });
    });
});
