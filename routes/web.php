<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\SlotController;
use App\Http\Controllers\Web\BookingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [HomeController::class, 'index'])->name('/');


Route::post('/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('user.logout');
Route::get('/edit-profile', [AuthController::class, 'editprofile'])->name('edit-profile');
Route::post('/update-profile', [AuthController::class, 'updateProfile'])->name('user.update.profile');

Route::get('/slots/by-date', [SlotController::class, 'getSlotsByDate'])->name('get.slots');

Route::post('/book-slot', [SlotController::class, 'bookSlot'])->name('book.slot');
Route::get('/stripe/success/{booking_id}', [SlotController::class, 'stripeSuccess'])->name('stripe.success');
Route::get('/stripe/cancel/{booking_id}', [SlotController::class, 'stripeCancel'])->name('stripe.cancel');

Route::get('my-booking', [BookingController::class, 'myBookings'])->name('my-booking');
Route::get('/filter-bookings', [BookingController::class, 'filterBookings'])->name('bookings.filter');

Route::get('/download-invoice/{id}', [BookingController::class, 'downloadInvoice'])->name('download.invoice');
Route::get('/download/slot-invoice/{id}', [BookingController::class, 'downloadSlotInvoice'])->name('download.slot.invoice');




Route::middleware(['auth'])->group(function () {

});

//...........include admin panel routes...................//
include 'admin.php';



