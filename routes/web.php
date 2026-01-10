<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageBuilderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Auth Routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Settings Routes
    Route::resource('settings', SettingsController::class)->only(['index', 'store']); // Using store for update mostly
    Route::post('settings/update', [SettingsController::class, 'update'])->name('settings.update');

    // Categories Routes
    Route::resource('categories', CategoryController::class);

    // Builder Routes
    Route::get('builder', [PageBuilderController::class, 'index'])->name('builder.index');
    Route::get('builder/create', [PageBuilderController::class, 'create'])->name('builder.create');
    Route::post('builder/store', [PageBuilderController::class, 'store'])->name('builder.store');
    Route::get('builder/{id}/edit', [PageBuilderController::class, 'edit'])->name('builder.edit');
    Route::put('builder/{id}', [PageBuilderController::class, 'update'])->name('builder.update');
    Route::delete('builder/{id}', [PageBuilderController::class, 'destroy'])->name('builder.destroy');
    Route::post('builder/upload', [PageBuilderController::class, 'upload'])->name('builder.upload');

    // Orders Routes
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);

    // Users Routes
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'destroy']);

    // Blogs Routes
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);
});

// Front Routes
Route::get('category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::view('about', 'front.about')->name('about');
Route::view('contact', 'front.contact')->name('contact');
Route::get('projects/{slug}', [PageBuilderController::class, 'show'])->name('projects.show');

// Cart Routes
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Checkout Routes
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('checkout', [CheckoutController::class, 'process'])->name('checkout.process');
