<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return response()->json([
        'data'=>"Unauthenticated ",
        'status'=>"401",
        'type'=>'error'
    ]);
});
