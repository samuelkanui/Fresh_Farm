<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

// Customer Dashboard
Route::get('dashboard', function () {
    $user = auth()->user();
    if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    $recentOrders = $user?->orders()
        ->with('items.product')
        ->latest()
        ->limit(3)
        ->get();

    $upcomingBookings = $user?->bookings()
        ->where('status', '!=', 'cancelled')
        ->whereDate('booking_date', '>=', now())
        ->orderBy('booking_date')
        ->limit(3)
        ->get();

    return Inertia::render('Dashboard', [
        'recentOrders' => $recentOrders,
        'upcomingBookings' => $upcomingBookings,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Orders (Authenticated)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    
    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Revenue Management
    Route::get('/revenue', [\App\Http\Controllers\Admin\RevenueController::class, 'index'])->name('revenue.index');
    
    // Order Management
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/pending', [\App\Http\Controllers\Admin\OrderController::class, 'pending'])->name('orders.pending');
    Route::post('/orders/{order}/approve', [DashboardController::class, 'approveOrder'])->name('orders.approve');
    Route::post('/orders/{order}/reject', [DashboardController::class, 'rejectOrder'])->name('orders.reject');
    
    // Booking Management
    Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/pending', [\App\Http\Controllers\Admin\BookingController::class, 'pending'])->name('bookings.pending');
    Route::post('/bookings/{booking}/confirm', [DashboardController::class, 'confirmBooking'])->name('bookings.confirm');
    
    // Customer Management
    Route::get('/customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    
    // Product Management
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
});

require __DIR__.'/settings.php';
