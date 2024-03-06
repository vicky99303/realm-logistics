<?php

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\Tracker;
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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/logout', [RegisterController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/insertJourney', [Tracker::class, 'insertJourney']);
    Route::post('/insertCurrentLocation', [Tracker::class, 'insertCurrentLocation']);
    Route::post('/profile_update', [RegisterController::class, 'profile_update_img']);
});
