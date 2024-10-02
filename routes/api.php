<?php

use App\Http\Controllers\DaysOffController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');


// Authenticated user route (fetch current user)
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('users', UserController::class);

// Authenticated routes
Route::middleware(['auth:sanctum'])->group(function () {

    // Admin-specific routes
    Route::middleware(['admin'])->group(function () {

        // Project management routes
        Route::resource('projects', ProjectController::class);

        // Department management routes
        Route::resource('departments', DepartmentController::class);
        Route::post('/assign-projects-departments/{department}', [DepartmentController::class, 'assignProjects']);
        Route::post('/assign-departments-projects/{project}', [ProjectController::class, 'assignDepartments']);

        Route::patch('/departments/{department}/update-user-position', [DepartmentController::class, 'updateUserPosition']);
        Route::patch('/projects/{project}/update-user-role', [ProjectController::class, 'updateUserRole']);

        // User management routes

        // Employees-related routes
        Route::get('employees', [UserController::class, 'getEmployees']);

        // Assignment routes (assign departments/projects to users)
        Route::post('assign-departments/{user}', [UserController::class, 'assignDepartments']);
        Route::post('assign-projects/{user}', [UserController::class, 'assignProjects']);
        Route::post('/assign-users-departments/{department}', [DepartmentController::class, 'assignUsers']);
        Route::post('/assign-users-projects/{project}', [ProjectController::class, 'assignUsers']);

        Route::post('/user/{user}/remove-projects', [UserController::class, 'removeFromProject']);
        Route::post('/user/{user}/remove-departments', [UserController::class, 'removeFromDepartment']);


        // Days Off (Vacation) management for admin
        Route::get('/vacation', [DaysOffController::class, 'index']);
        Route::patch('/vacation/{days_off}', [DaysOffController::class, 'update']);
    });

    // Employee-specific routes
    Route::get('/employee-projects', [ProjectController::class, 'getEmployeeProjects']);
    Route::get('/employee-vacation', [DaysOffController::class, 'getEmployeeDaysOff']);
    Route::get('/employee-departments', [DepartmentController::class, 'getEmployeeDepartments']);

    // View specific project/department by employee
    Route::get('/view-project/{project}', [ProjectController::class, 'getEmployeeProjectById']);
    Route::get('/view-department/{department}', [DepartmentController::class, 'getEmployeeDepartmentsById']);
    Route::get('/profile', [UserController::class, 'profile']);

    // Search functionality
    Route::post('/search', [SearchController::class, 'search']);

    // Request vacation (for employees)
    Route::post('/request-vacation', [DaysOffController::class, 'store']);

    Route::patch('/profile/update/{user}', [UserController::class, 'updateProfile']);

    Route::patch('/update-password/', [UserController::class, 'updatePassword']);

    // Logout route
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

