<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SocialiteController;
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
    Route::get('cek-token',[LoginController::class,'checkToken'])->middleware('auth:api');
    Route::middleware(['auth:api','emailIsVerified'])->get('/user', function () {
        return auth()->user();
    });

    Route::get('/social/{provider}', [SocialiteController::class,'redirectProvider']);
    Route::get('/social/{provider}/callback', [SocialiteController::class,'handleProviderCallback']);
});

Route::group(['middleware' => [],'prefix'=>'campaign'], function () {
    Route::get('random/{count}',[CampaignController::class,'random']);
    Route::post('/store',[CampaignController::class,'store']);
    Route::get('/',[CampaignController::class,'index']);
    Route::get('/{id}',[CampaignController::class,'show']);
    Route::get('/search/{keyword}',[CampaignController::class,'search']);
});
Route::group(['middleware' => ['api'],'prefix'=>'blog'], function () {
    Route::get('random/{count}',[BlogController::class,'random']);
    Route::post('store',[BlogController::class,'store']);
});
