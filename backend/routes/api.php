<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PasswordResetController;
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class,'login'])->name('login');
    Route::post('signup', [AuthController::class,'signup']);

});
Route::group(['middleware' => 'auth:api'], function() {
    Route::apiResource('products',ProductController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', [PasswordResetController::class,'create']);
    Route::get('find/{token}', [PasswordResetController::class,'find']);
    Route::post('reset', [PasswordResetController::class,'reset']);
});


