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
use App\Http\Controllers\ReviewController;

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

    // Product Page Builder (Formerly General Page Builder)
    Route::get('products', [GeneralPageController::class, 'index'])->name('products.index');
    Route::get('products/create', [GeneralPageController::class, 'create'])->name('products.create');
    Route::post('products/store', [GeneralPageController::class, 'store'])->name('products.store');
    Route::get('products/{id}/edit', [GeneralPageController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [GeneralPageController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [GeneralPageController::class, 'destroy'])->name('products.destroy');

    // Page Builder (Formerly Builder/Landing Page Builder)
    Route::get('pages', [PageBuilderController::class, 'index'])->name('pages.index');
    Route::get('pages/create', [PageBuilderController::class, 'create'])->name('pages.create');
    Route::post('pages/store', [PageBuilderController::class, 'store'])->name('pages.store');
    Route::get('pages/{id}/edit', [PageBuilderController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{id}', [PageBuilderController::class, 'update'])->name('pages.update');
    Route::delete('pages/{id}', [PageBuilderController::class, 'destroy'])->name('pages.destroy');
    Route::post('pages/upload', [PageBuilderController::class, 'upload'])->name('pages.upload');

    // Orders Routes
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);

    // Users Routes
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'destroy']);

    // Blogs Routes
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);

    // Plans & FAQs
    Route::resource('plans', \App\Http\Controllers\Admin\PlanController::class);
    Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);
    Route::post('subscriptions/{subscription}/notify', [\App\Http\Controllers\Admin\SubscriptionController::class, 'notify'])->name('subscriptions.notify');
    Route::resource('subscriptions', \App\Http\Controllers\Admin\SubscriptionController::class);
    Route::resource('newsletters', \App\Http\Controllers\Admin\NewsletterController::class)->only(['index', 'destroy']);
    Route::post('newsletters/{newsletter}/toggle', [\App\Http\Controllers\Admin\NewsletterController::class, 'toggle'])->name('newsletters.toggle');
    
    // Reviews Management
    Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::post('reviews/{review}/toggle', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleStatus'])->name('reviews.toggle');
});

// Newsletter Route
Route::post('newsletter/subscribe', [App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Front Routes
Route::get('category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('products/{slug}', [GeneralPageController::class, 'show'])->name('products.show');
Route::view('about', 'front.about')->name('about');
Route::view('contact', 'front.contact')->name('contact');
Route::get('pages/{slug}', [PageBuilderController::class, 'show'])->name('pages.show');
Route::get('blogs', [\App\Http\Controllers\BlogController::class, 'index'])->name('blogs.index');
Route::get('blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blogs.show');

// Review Routes
Route::post('reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');

// Cart Routes
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Checkout Routes
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('checkout', [CheckoutController::class, 'process'])->name('checkout.process');
