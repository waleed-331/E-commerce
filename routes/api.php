<?php

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

Route::post('/Register',[\App\Http\Controllers\UserController::class,'Register']);
Route::post('/Login',[\App\Http\Controllers\UserController::class,'Login']);

Route::group(['middleware' => 'auth:sanctum'], function(){

    Route::apiResource('/products',\App\Http\Controllers\ProductController::class);
    Route::get('/sort',[\App\Http\Controllers\ProductController::class,'sort']);
    Route::get('/search',[\App\Http\Controllers\ProductController::class,'search']);
    Route::get('/show_profile',[\App\Http\Controllers\UserController::class,'show_profile']);
    Route::get('/buy',[\App\Http\Controllers\ProductController::class,'buy']);




});
