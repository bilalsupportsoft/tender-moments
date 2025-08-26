<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\Admin\BookingController;


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



Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminAuthController::class, 'index']);

    Route::get('login', [AdminAuthController::class, 'login'])->name('login');

    Route::post('login', [AdminAuthController::class, 'postLogin'])->name('login.post');

    Route::get('forget-password', [AdminAuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');

    Route::post('forget-password', [AdminAuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post');

    Route::get('reset-password/{token}', [AdminAuthController::class, 'showResetPasswordForm'])->name('reset.password.get');

    Route::post('reset-password', [AdminAuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    Route::middleware(['admin'])->group(function () {
    	Route::get('dashboard', [AdminAuthController::class, 'adminDashboard'])->name('dashboard');

        Route::get('change-password', [AdminAuthController::class, 'changePassword'])->name('change.password');

        Route::post('update-password', [AdminAuthController::class, 'updatePassword'])->name('update.password');

        Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('profile', [AdminAuthController::class, 'adminProfile'])->name('profile');

        Route::post('profile', [AdminAuthController::class, 'updateAdminProfile'])->name('update.profile');

        Route::get('user-chart-data', [AdminAuthController::class, 'UserChartData'])->name('UserChartData');
        Route::get('booking-chart-data', [AdminAuthController::class, 'BookingChartData'])->name('BookingChartData');




        Route::name('slot.')->group(function () {
            Route::get("slots", [SlotController::class, 'index'])->name('index');
            Route::get("slots-create", [SlotController::class, 'create'])->name('create');
            Route::post("slots-store", [SlotController::class, 'store'])->name('store');
            Route::delete("slots/delete/{id}", [SlotController::class, 'destroy'])->name('destroy');
            Route::get('slots/{id}/view', [SlotController::class, 'edit'])->name('edit');

        });


        Route::name('bookings.')->group(function () {
            Route::get("bookings", [BookingController::class, 'index'])->name('index');
            Route::get("bookings-create", [BookingController::class, 'create'])->name('create');
            Route::post("bookings-store", [BookingController::class, 'store'])->name('store');
            Route::delete("bookings/delete/{id}", [BookingController::class, 'destroy'])->name('destroy');
            Route::get('bookings/{id}/view', [BookingController::class, 'edit'])->name('edit');
            Route::post('/bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('updateStatus');
            Route::put('/bookings/cancel/{id}', [BookingController::class, 'cancelBooking'])->name('bookings.cancel');

        });


        Route::name('users.')->group(function () {

            Route::get("users", [AdminUserController::class, 'index'])->name('index');

            Route::post("users/status", [AdminUserController::class, 'userStatus'])->name('status');

            Route::delete("users/delete/{id}", [AdminUserController::class, 'destroy'])->name('destroy');

            Route::get("users/{id}", [AdminUserController::class, 'show'])->name('show');

        });

        Route::name('contacts.')->group(function () {

            Route::get("contacts", [ContactController::class, 'index'])->name('index');

            Route::get("contacts/all", [ContactController::class, 'getallcontact'])->name('allcontact');

            Route::delete("contacts/delete/{id}", [ContactController::class, 'destroy'])->name('destroy');
        });

        Route::name('page.')->group(function () {

            Route::get("page/create/{key}", [PageController::class, 'create'])->name('create');

            Route::put("page/update/{key}", [PageController::class, 'update'])->name('update');
        });
    });

});

Route::middleware(['auth'])->group(function () {
});



