<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('projects', ProjectController::class);
Route::resource('departments', DepartmentController::class);

Route::middleware(['startSession'])->post('/login', [AuthenticatedSessionController::class, 'store']);
Route::resource('users', UserController::class)->except('destroy');
Route::delete('/user-delete/{id}', [UserController::class, 'destroy']);
Route::get('employees', [UserController::class, 'getEmployees']);
Route::resource('roles', RoleController::class);
Route::resource('vacations', VacationController::class);


