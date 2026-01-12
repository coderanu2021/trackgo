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
use App\Http\Controllers\GeneralPageController;
use App\Http\Controllers\BannerController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('faqs', [HomeController::class, 'faqs'])->name('faqs');


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

    // Banners
    Route::resource('banners', BannerController::class);

    // General Page Builder
    Route::get('pages', [GeneralPageController::class, 'index'])->name('pages.index');
    Route::get('pages/create', [GeneralPageController::class, 'create'])->name('pages.create');
    Route::post('pages/store', [GeneralPageController::class, 'store'])->name('pages.store');
    Route::get('pages/{id}/edit', [GeneralPageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{id}', [GeneralPageController::class, 'update'])->name('pages.update');
    Route::delete('pages/{id}', [GeneralPageController::class, 'destroy'])->name('pages.destroy');

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

    // Plans & FAQs
    Route::resource('plans', \App\Http\Controllers\Admin\PlanController::class);
    Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);
    Route::resource('newsletters', \App\Http\Controllers\Admin\NewsletterController::class)->only(['index', 'destroy']);
    Route::post('newsletters/{newsletter}/toggle', [\App\Http\Controllers\Admin\NewsletterController::class, 'toggle'])->name('newsletters.toggle');
});

// Newsletter Route
Route::post('newsletter/subscribe', [App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Front Routes
Route::get('category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('page/{slug}', [GeneralPageController::class, 'show'])->name('pages.show');
Route::view('about', 'front.about')->name('about');
Route::view('contact', 'front.contact')->name('contact');
Route::get('projects/{slug}', [PageBuilderController::class, 'show'])->name('projects.show');
Route::get('blogs', [\App\Http\Controllers\BlogController::class, 'index'])->name('blogs.index');
Route::get('blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blogs.show');

// Cart Routes
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Checkout Routes
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('checkout', [CheckoutController::class, 'process'])->name('checkout.process');
