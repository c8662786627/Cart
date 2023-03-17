<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::group(['middleware'=>'auth:api'],function(){
    Route::post('/user', [AuthController::class, 'user']);
});

Route::group(['prefix'=>'product'],function(){
    Route::get('/',[ProductController::class,'listPage']);
    Route::post('/create',[ProductController::class,'productCreate']);
    
    Route::group(['prefix'=>'{product_id}'],function(){
        Route::group(['middleware'=>'user.auth.admin'],function(){
            Route::get('/',[ProductController::class,'productPage']);
            Route::put('/',[ProductController::class,'productUpdate']);
            Route::post('/',[ProductController::class,'productDel']);
        });
    });
});