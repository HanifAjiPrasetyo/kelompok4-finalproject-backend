<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/getProvinces', [AddressController::class, 'getProvinces']);
Route::get('/getCities/{id}', [AddressController::class, 'getCities']);
Route::get('/getPostalCode/{id}', [AddressController::class, 'getPostalCode']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
Route::group([
    'middleware' => 'api',

], function () {
    Route::resource('/product', ProductController::class);
    Route::resource('/cart', CartController::class);
    Route::delete('/cart/{cart}/products/{productId}', [CartController::class, 'destroy'])->name('carts.destroy.product');
});
