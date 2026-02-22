<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageBuilderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PaymentController;
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
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// WhatsApp Authentication Routes
Route::get('whatsapp-login', [\App\Http\Controllers\WhatsAppAuthController::class, 'showLoginForm'])->name('whatsapp.login');
Route::post('whatsapp/send-otp', [\App\Http\Controllers\WhatsAppAuthController::class, 'sendOtp'])->name('whatsapp.send-otp');
Route::post('whatsapp/verify-otp', [\App\Http\Controllers\WhatsAppAuthController::class, 'verifyOtp'])->name('whatsapp.verify-otp');
Route::post('whatsapp/resend-otp', [\App\Http\Controllers\WhatsAppAuthController::class, 'resendOtp'])->name('whatsapp.resend-otp');

// Admin-specific login
Route::get('admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');

// Customer Routes
Route::middleware('auth')->prefix('customer')->name('customer.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('orders', [\App\Http\Controllers\CustomerController::class, 'orders'])->name('orders');
    Route::get('profile', [\App\Http\Controllers\CustomerController::class, 'profile'])->name('profile');
    Route::post('profile', [\App\Http\Controllers\CustomerController::class, 'updateProfile'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Settings Routes
    Route::resource('settings', SettingsController::class)->only(['index', 'store']); // Using store for update mostly
    Route::post('settings/update', [SettingsController::class, 'update'])->name('settings.update');

    // Categories Routes
    Route::resource('categories', CategoryController::class);

    // Banners
    Route::resource('banners', BannerController::class);

    // PRODUCT BUILDER - E-commerce Products (with price, stock, cart)
    Route::get('products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
    Route::post('products/store', [\App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('products/{id}/edit', [\App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');

    // PAGE BUILDER - General Pages (About, Contact, Landing Pages)
    Route::get('pages', [PageBuilderController::class, 'index'])->name('pages.index');
    Route::get('pages/create', [PageBuilderController::class, 'create'])->name('pages.create');
    Route::post('pages/store', [PageBuilderController::class, 'store'])->name('pages.store');
    Route::get('pages/{id}/edit', [PageBuilderController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{id}', [PageBuilderController::class, 'update'])->name('pages.update');
    Route::delete('pages/{id}', [PageBuilderController::class, 'destroy'])->name('pages.destroy');
    Route::post('pages/upload', [PageBuilderController::class, 'upload'])->name('pages.upload');
    
    // Simple test upload without validation
    Route::post('test-simple-upload', function(Request $request) {
        \Log::info('Simple upload test', [
            'has_file' => $request->hasFile('image'),
            'all_files' => $request->allFiles(),
            'all_input' => $request->all(),
        ]);
        
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No file in request'], 400);
        }
        
        $file = $request->file('image');
        
        return response()->json([
            'success' => true,
            'file_info' => [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'error' => $file->getError(),
                'is_valid' => $file->isValid(),
            ]
        ]);
    })->name('test-simple-upload');
    
    // Debug what Laravel receives
    Route::post('debug-request', function(Request $request) {
        return response()->json([
            'method' => $request->method(),
            'headers' => $request->headers->all(),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
            'has_files' => !empty($request->allFiles()),
            'files' => $request->allFiles(),
            'input' => $request->all(),
            'server' => [
                'CONTENT_LENGTH' => $_SERVER['CONTENT_LENGTH'] ?? 'not set',
                'CONTENT_TYPE' => $_SERVER['CONTENT_TYPE'] ?? 'not set',
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'] ?? 'not set',
            ]
        ]);
    })->name('debug-request');
    
    // Very simple upload test
    Route::post('very-simple-upload', function(Request $request) {
        \Log::info('Very simple upload test', [
            'method' => $request->method(),
            'has_file' => $request->hasFile('image'),
            'files_count' => count($request->allFiles()),
            'all_files' => $request->allFiles(),
        ]);
        
        return response()->json([
            'received_files' => count($request->allFiles()),
            'has_image' => $request->hasFile('image'),
            'all_files' => $request->allFiles(),
        ]);
    })->name('very-simple-upload');
    
    // Test upload route for debugging
    Route::get('test-upload', function() {
        return view('admin.test-upload');
    })->name('test-upload');
    
    // Simple upload test
    Route::get('simple-upload-test', function() {
        return view('admin.simple-upload-test');
    })->name('simple-upload-test');
    
    // Debug upload info
    Route::get('upload-info', function() {
        return response()->json([
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'max_file_uploads' => ini_get('max_file_uploads'),
            'memory_limit' => ini_get('memory_limit'),
            'uploads_dir_exists' => is_dir(storage_path('app/public/uploads')),
            'uploads_dir_writable' => is_writable(storage_path('app/public/uploads')),
            'storage_link_exists' => is_dir(public_path('storage')),
        ]);
    })->name('upload-info');
    
    // PHP info for debugging
    Route::get('php-info', function() {
        phpinfo();
    })->name('php-info');

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
    // Reviews Management
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::post('reviews/{review}/toggle', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleStatus'])->name('reviews.toggle');
    
    // Gallery Management
    Route::get('gallery', [\App\Http\Controllers\GalleryController::class, 'adminIndex'])->name('gallery.index');
    Route::get('gallery/create', [\App\Http\Controllers\GalleryController::class, 'create'])->name('gallery.create');
    Route::post('gallery', [\App\Http\Controllers\GalleryController::class, 'store'])->name('gallery.store');
    Route::get('gallery/{id}/edit', [\App\Http\Controllers\GalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('gallery/{id}', [\App\Http\Controllers\GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('gallery/{id}', [\App\Http\Controllers\GalleryController::class, 'destroy'])->name('gallery.destroy');
});

// Test route for debugging
Route::get('/test-products', function() {
    $products = \App\Models\Page::where('is_active', true)->latest()->take(8)->get();
    return view('test-products', compact('products'));
});

// Test route for layout changes
Route::get('/test-layout', function() {
    return view('test-layout');
});

// Test route for home controller
Route::get('/test-home', [\App\Http\Controllers\HomeController::class, 'index']);

// Simple home test
Route::get('/home-simple', function() {
    $products = \App\Models\Page::where('is_active', true)->latest()->take(8)->get();
    $categories = \App\Models\Category::where('is_active', true)->whereNull('parent_id')->with('children')->get();
    $blogs = \App\Models\Blog::where('is_published', true)->latest()->take(3)->get();
    $hero_slides = \App\Models\Banner::where('is_active', true)->orderBy('order')->get();
    $brands = \App\Models\Brand::where('status', true)->get();
    
    return view('home-simple', compact('products', 'categories', 'blogs', 'hero_slides', 'brands'));
});

// Front Routes
Route::get('shop', [\App\Http\Controllers\ProductController::class, 'shop'])->name('shop');
Route::get('gallery', [\App\Http\Controllers\GalleryController::class, 'index'])->name('gallery');
Route::get('categories', [\App\Http\Controllers\CategoriesController::class, 'index'])->name('categories');
Route::get('category/{slug}', [\App\Http\Controllers\CategoriesController::class, 'show'])->name('category.show');
Route::get('products/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('about', [PageBuilderController::class, 'showBySlug'])->name('about');
Route::get('contact', [\App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');
Route::get('pages/{slug}', [PageBuilderController::class, 'show'])->name('pages.show');
Route::get('blogs', [\App\Http\Controllers\BlogController::class, 'index'])->name('blogs.index');
Route::get('blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blogs.show');

// Review Routes
Route::post('reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');

// Cart Routes
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/add/{id}', [CartController::class, 'add'])->name('cart.add.ajax'); // AJAX route
Route::patch('cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Wishlist Routes
Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add.ajax'); // AJAX route
Route::delete('wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');

// Checkout Routes
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('order/{order}/success', [CheckoutController::class, 'orderSuccess'])->name('order.success');

// Payment Routes
Route::get('payment/{order}/methods', [PaymentController::class, 'showPaymentMethods'])->name('payment.methods');
Route::post('payment/{order}/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::post('payment/{payment}/process', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('payment/{payment}/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('payment/{payment}/failed', [PaymentController::class, 'failed'])->name('payment.failed');
Route::post('payment/{payment}/verify', [PaymentController::class, 'verify'])->name('payment.verify');

// Payment Webhooks (no auth required)
Route::post('webhook/payment/{gateway}', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Test routes outside of admin middleware
Route::post('test-upload-no-auth', function(Request $request) {
    \Log::info('No auth upload test', [
        'has_file' => $request->hasFile('image'),
        'files' => $request->allFiles(),
    ]);
    
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        return response()->json([
            'success' => true,
            'file_received' => true,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
        ]);
    }
    
    return response()->json(['error' => 'No file received']);
})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
