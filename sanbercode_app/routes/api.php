<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function () {
    return auth()->user();
});

Route::group(['prefix'=>'auth'],function (){
    Route::post('register',[RegisterController::class,'index']);
    Route::post('login',[LoginController::class,'index']);
    Route::get('logout',[LoginController::class,'logout'])->middleware('auth:api');
    Route::middleware('auth:api')->get('/user', function () {
        return auth()->user();
    });
});
