<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('projects', ProjectController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('positions', PositionController::class);

Route::middleware(['startSession'])->post('/login', [AuthenticatedSessionController::class, 'store']);
