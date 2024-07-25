<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
   Route::get('/',[StudentController::class,'index']);
   Route::post('/logout',[AuthController::class,'logout']);
   Route::post('/blogpost',[StudentController::class,'blogpost']);
   Route::delete('/blogpost/{id}',[StudentController::class,'destroy']);
   Route::put('/blogpost/{id}',[StudentController::class,'updatepost']);
   Route::get('/blogpost/{id}',[StudentController::class,'singlepost']);
});
