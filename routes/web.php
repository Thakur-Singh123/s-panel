<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

//Login
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('submit-login', [App\Http\Controllers\Auth\LoginController::class, 'submit_login'])->name('login.submit');
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

//Supplier/Sub Supplier Middleware
Route::middleware(['supplier'])->group(function () {
    //Common dashboard
    Route::get('dashboard', [App\Http\Controllers\Supplier\DashboardController::class, 'dashboard'])->name('dashboard');
    //Booking
    Route::get('all-bookings', [App\Http\Controllers\Supplier\BookingController::class, 'index'])->name('supplier.bookings');
    Route::get('booking-details/{id}', [App\Http\Controllers\Supplier\BookingController::class, 'booking_details'])->name('supplier.booking.details');
    Route::get('bookings/{id}/new-voucher', [App\Http\Controllers\Supplier\BookingController::class, 'new_voucher'])->name('supplier.bookings.new-voucher');
    //Add Tour
    Route::get('tours-list', [App\Http\Controllers\Supplier\Tour\TourController::class, 'index'])->name('supplier.tours.index');

});