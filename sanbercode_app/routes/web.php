<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Auth::routes();
Route::get('unverified_email', function () {
    return view('error.unverified_email');
})->name('unverified_email');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
Route::group(['middleware' => ['auth','emailIsVerified']], function () {
    Route::get('/route1', function () {
        return 'route 1 gan ';
    });
});
Route::group(['middleware' => ['auth','checkRole:admin','emailIsVerified']], function () {
    Route::get('/route2', function () {
        return 'route2 gan';
    });
});






