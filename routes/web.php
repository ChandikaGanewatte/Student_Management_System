
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;

// Root route
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Public routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.submit');
});

// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Student CRUD routes
    Route::resource('students', StudentController::class);

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});

Route::get('/students/deleted', [StudentController::class, 'deleted'])
    ->name('students.deleted');

Route::post('/students/{id}/restore', [StudentController::class, 'restore'])
    ->name('students.restore');

Route::resource('students', StudentController::class);