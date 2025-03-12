<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


//Authenticaton Routes
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');


// Protected Route)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);  // List all tasks
    Route::post('/tasks', [TaskController::class, 'store']); // Create task
    Route::get('/tasks/{task}', [TaskController::class, 'show']); // Get task
    Route::put('/tasks/{task}', [TaskController::class, 'update']); // Update task
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']); // Delete task

});

















// Route::middleware('auth:sanctum')->apiResource('tasks', TaskController::class);
    // Route::get('/user', function (Request $request) {
    //     return $request->user();

