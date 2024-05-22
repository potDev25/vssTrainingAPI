<?php

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

Route::middleware('auth:sanctum')->group(function() {
    Route::controller(App\Http\Controllers\UserController::class)->group(function(){
        Route::get('/users', 'index');
        Route::get('/users/{id}', 'show');
        Route::post('/users/store', 'store');
        Route::delete('/users/destroy/{user}', 'destroy');
        Route::post('/users/update/{user}', 'update');
    
        //change user status api route
        Route::post('/users/change-status/{user}', 'updateStatus');
        Route::post('/users/logout', 'logout');
    });
});


Route::controller(App\Http\Controllers\AuthenticationController::class)->group(function(){
    Route::post('/login', 'login')->name('login');
});
