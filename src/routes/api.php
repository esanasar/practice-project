<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/test', function (){
    dd(1);
});
Route::prefix('books')
    ->controller(BookController::class)
    ->group( function (){

        Route::get('/', 'index');
        Route::post('/store' , 'store');
});

Route::post('/orders/store', [OrderController::class, 'store']);
