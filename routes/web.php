<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Admin Only Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

/*
|--------------------------------------------------------------------------
| Admin & Manager Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    // Booking management routes
    Route::get('/manage-bookings', [BookingController::class, 'manageBookings'])
        ->name('bookings.manage.index');
    Route::post('/manage-bookings/{booking}/confirm', [BookingController::class, 'confirmBooking'])
        ->name('bookings.manage.confirm');
    Route::post('/manage-bookings/{booking}/cancel', [BookingController::class, 'cancelBooking'])
        ->name('bookings.manage.cancel');

    Route::resource('destinations', DestinationController::class)->only(['index', 'store', 'create', 'update', 'destroy', 'edit']);
    Route::resource('gallery', GalleryController::class)->only(['index', 'store', 'create', 'edit', 'update', 'destroy']);
    Route::resource('feedback', FeedbackController::class)->only(['index', 'store', 'create', 'show', 'update', 'destroy', 'edit']);

    // Hotel Management
    Route::resource('hotel', HotelController::class);

    // Room Management
    Route::get('hotel/{hotel}/rooms/create', [HotelController::class, 'createRoom'])->name('hotel.rooms.create');
    Route::post('hotel/{hotel}/rooms', [HotelController::class, 'storeRoom'])->name('hotel.rooms.store');
    Route::get('hotel/{hotel}/rooms/{room}/edit', [HotelController::class, 'editRoom'])->name('hotel.rooms.edit');
    Route::put('hotel/{hotel}/rooms/{room}', [HotelController::class, 'updateRoom'])->name('hotel.rooms.update');
    Route::delete('hotel/{hotel}/rooms/{room}', [HotelController::class, 'destroyRoom'])->name('hotel.rooms.destroy');

    // Booking Management
    Route::get('hotel/bookings', [HotelController::class, 'bookings'])->name('hotel.bookings.index');
    Route::get('hotel/bookings/create', [HotelController::class, 'createBooking'])->name('hotel.bookings.create');
    Route::post('hotel/bookings', [HotelController::class, 'storeBooking'])->name('hotel.bookings.store');
    Route::get('hotel/bookings/{booking}/edit', [HotelController::class, 'editBooking'])->name('hotel.bookings.edit');
    Route::put('hotel/bookings/{booking}', [HotelController::class, 'updateBooking'])->name('hotel.bookings.update');
    Route::post('hotel/bookings/{booking}/confirm', [HotelController::class, 'confirmBooking'])->name('hotel.bookings.confirm');
    Route::post('hotel/bookings/{booking}/cancel', [HotelController::class, 'cancelBooking'])->name('hotel.bookings.cancel');
    Route::post('hotel/bookings/{booking}/checkin', [HotelController::class, 'checkIn'])->name('hotel.bookings.checkin');
    Route::post('hotel/bookings/{booking}/checkout', [HotelController::class, 'checkOut'])->name('hotel.bookings.checkout');
    Route::post('hotel/bookings/{booking}/assign-room', [HotelController::class, 'assignRoom'])->name('hotel.bookings.assign-room');

    // Availability
    Route::get('hotel/availability', [HotelController::class, 'checkAvailability'])->name('hotel.bookings.availability');
});

/*
|--------------------------------------------------------------------------
| Public Destination View
|--------------------------------------------------------------------------
*/

Route::get('/destinations/{destination}', [DestinationController::class, 'show'])
    ->name('destinations.show');

/*
|--------------------------------------------------------------------------
| Dashboard (No Closure)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [UtilityController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| User Accessible Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->group(function () {
    // User destinations - view only (read-only access to active destinations)
    Route::get('/user-destinations', [DestinationController::class, 'userIndex'])
        ->name('user.destinations.index');
    
    // User gallery - view only (view all gallery images)
    Route::get('/user-gallery', [GalleryController::class, 'userIndex'])
        ->name('user.gallery.index');
    
    // User bookings
    Route::get('/bookings/create/{destination}', [BookingController::class, 'createForDestination'])
        ->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'storeUserBooking'])
        ->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'userBookings'])
        ->name('bookings.user.index');
});

/*
|--------------------------------------------------------------------------
| Utility Routes (No Closure)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/check-role', [UtilityController::class, 'checkRole']);
    Route::get('/set-admin', [UtilityController::class, 'setAdmin']);
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';