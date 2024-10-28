<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// For AuthController
Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);
Route::get("/checkToken", [AuthController::class, 'checkToken'])->middleware("auth:api");



// For BookController
Route::prefix("/books")->group(function(){
    Route::get("/", [BookController::class, 'index']);
    Route::post("/", [BookController::class, 'store'])->middleware("auth:api");
    Route::get("/{book}", [BookController::class, 'show']);
    Route::delete("/{book}", [BookController::class, 'destroy'])->middleware("auth:api");
    Route::patch("/{book}", [BookController::class, 'update'])->middleware("auth:api");
});

