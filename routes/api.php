<?php

use App\Http\Controllers\DaysOffController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware(['admin'])->group(function () {  // 'admin' middleware checks for admin role
        Route::resource('projects', ProjectController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('users', UserController::class)->except('destroy');
        Route::delete('/user-delete/{id}', [UserController::class, 'destroy']);
        Route::get('employees', [UserController::class, 'getEmployees']);
        Route::post('assign-departments/{user}', [UserController::class, 'assignDepartments']);
        Route::post('assign-projects/{user}', [UserController::class, 'assignProject']);
        Route::post('/assign-projects', [UserController::class, 'assignProjects']);
        Route::get('/vacation', [DaysOffController::class, 'index']);
        Route::patch('/vacation/{days_off}', [DaysOffController::class, 'update']);
        Route::post('/search', [\App\Http\Controllers\SearchController::class, 'search']);
    });

    Route::post('/request-vacation', [DaysOffController::class, 'store']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('/user', [AuthenticatedSessionController::class, 'user']);
    Route::post('/request-vacation', [DaysOffController::class, 'store']);
    Route::get('/employee-vacation', [DaysOffController::class, 'getEmployeeDaysOff']);
});
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/assign-users/{department}', [DepartmentController::class, 'assignUsers']);

Route::post('/login', [AuthenticatedSessionController::class, 'store']);




Route::post('/login', [AuthenticatedSessionController::class, 'store']);



