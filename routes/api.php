<?php

use App\Http\Controllers\ParentsController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UserController::class)->group(function(){
    Route::get('/users', 'index');
    Route::get('/users/{user}', 'show');
    Route::post('/users/store', 'store');
    Route::delete('/users/destroy/{user}', 'destroy');
    Route::post('/users/update/{user}', 'update');
});

