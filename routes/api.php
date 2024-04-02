<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\InventoryConroller;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::group(['prefix'=>'user'],function (){
    Route::group(['prefix'=>'auth'],function (){
        Route::controller(AuthController::class)->group(function(){
            Route::post('login', 'login');
            Route::post('register', 'register');
        });
    });

    Route::middleware('auth:sanctum')->group( function () {
      Route::group(['prefix'=>'profile'],function (){
            Route::controller(AuthController::class)->group(function(){
                Route::get('me', 'me');
                Route::post('logout', 'logout');
            });
        });


        Route::group(['prefix'=>'items'],function (){
            Route::controller(ItemController::class)->group(function(){
                Route::get('/', 'index');
                Route::post('/store', 'store');
                Route::get('/show/{id}', 'show');
                Route::post('/update', 'update');
                Route::post('/delete', 'destroy');
            });
        });


        Route::group(['prefix'=>'inventory'],function (){
            Route::controller(InventoryConroller::class)->group(function(){
                Route::get('/', 'index');
                Route::post('/store', 'store');
                Route::get('/show/{id}', 'show');
                Route::post('/update', 'update');
                Route::post('/delete', 'destroy');
                Route::get('/get-item', 'getItem');
            });
        });

    });

});
