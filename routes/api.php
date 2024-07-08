<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['startSession'])->post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/projects', [ProjectController::class, 'store']);
Route::get('/projects/get', [ProjectController::class, 'index']);
Route::put('/projects/update/{project}', [ProjectController::class, 'update']);
Route::delete('/projects/delete/{project}', [ProjectController::class, 'destroy']);

