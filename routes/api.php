<?php

use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\FilmController;
use App\Http\Controllers\Api\Admin\PromotionController;
use App\Http\Controllers\Api\Admin\TheaterController;
use App\Http\Controllers\Api\Auth\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::post('admin/category/create' , [CategoryController::class, 'store']);
// Route::get('admin/category', [CategoryController::class, 'index']);

Route::group(['middleware' => 'auth:sanctum'], function(){
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
        Route::put('admin/promotion/update', 'update') -> name('admin.promotion.update');
        Route::delete('admin/promotion/delete', 'delete') -> name('admin.promotion.delete');
    });

    Route::controller(TheaterController::class) -> group(function(){
        Route::get('admin/theater/index', 'index') -> name('admin.theater.index');
        Route::post('admin/theater/create', 'store') -> name('admin.theater.create');
        Route::put('admin/theater/update', 'update') -> name('admin.theater.update');
        Route::delete('admin/theater/delete', 'delete') -> name('admin.theater.delete');
    });
});
