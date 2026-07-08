<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// 1. Public Visitor Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::post('/services/{id}/enquire', [EnquiryController::class, 'store'])->name('enquiries.store');
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        cookie()->queue('locale', $locale, 525600); // 1 year cookie
    }
    return redirect()->back();
})->name('lang.switch');

// 2. Authenticated Routes (All Roles)
Route::middleware(['auth'])->group(function () {
    // Traffic controller: redirects based on roles, or renders Customer Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Customer submits a booking request
    Route::post('/services/{id}/book', [BookingController::class, 'store'])->name('bookings.store');
    
    // Breeze Profile CRUD
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. Worker Dashboard Routes
Route::middleware(['auth', 'role:Worker'])->prefix('worker')->name('worker.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Worker\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\Worker\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\Worker\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\Worker\ProfileController::class, 'updatePassword'])->name('profile.password');
});

// 4. Admin Dashboard Routes (Admins and Super Admins)
Route::middleware(['auth', 'role:Admin|Super Admin'])->prefix('admin')->name('admin.')->group(function () {
    // Overview Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Service Management
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    
    // Worker Management
    Route::resource('workers', \App\Http\Controllers\Admin\WorkerController::class);
    Route::post('workers/{id}/assign', [\App\Http\Controllers\Admin\WorkerController::class, 'assignService'])->name('workers.assign');
    Route::post('workers/{id}/remove', [\App\Http\Controllers\Admin\WorkerController::class, 'removeService'])->name('workers.remove');
    
    // Booking Management
    Route::get('bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::patch('bookings/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'update'])->name('bookings.update');
    
    // Enquiry Management
    Route::get('enquiries', [\App\Http\Controllers\Admin\EnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('enquiries/{id}', [\App\Http\Controllers\Admin\EnquiryController::class, 'show'])->name('enquiries.show');
    Route::post('enquiries/{id}/reply', [\App\Http\Controllers\Admin\EnquiryController::class, 'reply'])->name('enquiries.reply');

    // Admin Management (Super Admin ONLY)
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class);
    });
});

require __DIR__.'/auth.php';
