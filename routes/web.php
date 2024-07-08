<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

//Route::resource('projects', ProjectController::class);

require __DIR__.'/auth.php';
