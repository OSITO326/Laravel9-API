<?php

use App\Http\Controllers\Api\Authapi;
use App\Http\Controllers\Api\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(Authapi::class)->group(function () {
  Route::post('register', 'register');
  Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
  Route::post('logout', [Authapi::class, 'logout']);
  Route::get('user', function (Request $request) {
    return $request->user();
  });
});

Route::controller(MenuController::class)->group(function() {
  Route::get('/products', 'index');
  Route::post('/product', 'store');
  Route::get('/product/{id}', 'show');
  Route::put('/product/{id}', 'update');
  Route::delete('/product/{id}', 'destroy');
});

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //return $request->user();
//});
