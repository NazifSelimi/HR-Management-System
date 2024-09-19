<?php

use App\Http\Controllers\DaysOffController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Get authenticated user
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Authenticated routes
Route::middleware(['auth:sanctum'])->group(function () {

    // Admin routes - restricted to admin role
    Route::middleware(['admin'])->group(function () {

        // Projects management
        Route::resource('projects', ProjectController::class);

        // Departments management
        Route::resource('departments', DepartmentController::class);

        // Users management
        Route::resource('users', UserController::class)->except('destroy');
        Route::delete('/user-delete/{id}', [UserController::class, 'destroy']);

        // Assignments
        Route::post('assign-departments/{user}', [UserController::class, 'assignDepartments']);
        Route::post('assign-projects/{user}', [UserController::class, 'assignProjects']);
        Route::post('/assign-users/{department}', [DepartmentController::class, 'assignUsers']);

        // Search functionality
        Route::post('/search', [SearchController::class, 'search']);

        // Days Off (Vacation) management
        Route::get('/vacation', [DaysOffController::class, 'index']);
        Route::patch('/vacation/{days_off}', [DaysOffController::class, 'update']);
    });

    // Employee-specific routes
    Route::get('/employee-projects', [ProjectController::class, 'getEmployeeProjects']);
    Route::post('/request-vacation', [DaysOffController::class, 'store']);
    Route::get('/employee-vacation', [DaysOffController::class, 'getEmployeeDaysOff']);

    // User-specific routes
    Route::get('/view-project/{project}', [ProjectController::class, 'getEmployeeProjectById']);

    // Update user position in department
    Route::post('/departments/{department}/update-user-position', [DepartmentController::class, 'updateUserPosition']);

    // Authentication routes
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});
