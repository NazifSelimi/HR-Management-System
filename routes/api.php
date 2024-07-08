<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/projects', [ProjectController::class, 'store']);
Route::get('/projects/get', [ProjectController::class, 'index']);
Route::put('/projects/update/{project}', [ProjectController::class, 'update']);

