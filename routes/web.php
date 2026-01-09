<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageBuilderController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Auth Routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Builder Routes
    Route::get('builder', [PageBuilderController::class, 'index'])->name('builder.index');
    Route::get('builder/create', [PageBuilderController::class, 'create'])->name('builder.create');
    Route::post('builder/store', [PageBuilderController::class, 'store'])->name('builder.store');
    Route::get('builder/{id}/edit', [PageBuilderController::class, 'edit'])->name('builder.edit');
    Route::put('builder/{id}', [PageBuilderController::class, 'update'])->name('builder.update');
    Route::delete('builder/{id}', [PageBuilderController::class, 'destroy'])->name('builder.destroy');
    Route::post('builder/upload', [PageBuilderController::class, 'upload'])->name('builder.upload');
});

// Front Routes
Route::get('projects/{slug}', [PageBuilderController::class, 'show'])->name('projects.show');
