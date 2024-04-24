<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::middleware(['role:manager,admin,super-admin'])->group(function () {
Route::namespace('admin')->group(function () {
    Route::prefix('booking')->group(function () {
        Route::post('/search', 'BookingController@searchByParams')->name('booking.search');
        Route::get('/', 'BookingController@index')->name('booking.index');
        Route::get('/{id}', 'BookingController@show')->name('booking.show')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/{id}/edit', 'BookingController@edit')->name('booking.edit')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}', 'BookingController@update')->name('booking.update')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}/edit/status', 'BookingController@changeStatus')->name('booking.status')->where('id', '^[1-9][0-9]{0,9}$');
        Route::delete('/{id}', 'BookingController@destroy')->name('booking.delete')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/create/{room_id}', 'BookingController@create')->name('booking.create')->where('id', '^[1-9][0-9]{0,9}$');
        Route::post('/store', 'BookingController@store')->name('booking.store');

    });
    Route::prefix('rooms')->group(function () {
        Route::get('/', 'RoomController@index')->name('rooms.index');
        Route::post('/search', 'RoomController@searchByParams')->name('rooms.search');
        Route::get('/{id}', 'RoomController@show')->name('rooms.show')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/{id}/edit', 'RoomController@edit')->name('rooms.edit')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}', 'RoomController@update')->name('rooms.update')->where('id', '^[1-9][0-9]{0,9}$');
        Route::delete('/{id}', 'RoomController@destroy')->name('rooms.delete')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/create', 'RoomController@create')->name('rooms.create');
        Route::post('/', 'RoomController@store')->name('rooms.store');
    });
    Route::prefix('guests')->group(function () {
        Route::get('/', 'GuestController@index')->name('guests.index');
        Route::get('/{id}/edit', 'GuestController@edit')->name('guests.edit')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}', 'GuestController@update')->name('guests.update')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/{id}', 'GuestController@show')->name('guests.show')->where('id', '^[1-9][0-9]{0,9}$');
        Route::delete('/{id}', 'GuestController@destroy')->name('guests.delete')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/create', 'GuestController@create')->name('guests.create');
        Route::post('/create/relation/', 'GuestController@relation')->name('guests.relation');
        Route::post('/', 'GuestController@store')->name('guests.store');
        Route::post('/search', 'GuestController@searchByParams')->name('guests.search');
    });

    Route::prefix('employees')->group(function () {
        Route::get('/', 'EmployeeController@index')->name('employees.index');
        Route::get('/{id}/edit', 'EmployeeController@edit')->name('employees.edit')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}', 'EmployeeController@update')->name('employees.update')->where('id', '^[1-9][0-9]{0,9}$');
        Route::delete('/{id}', 'EmployeeController@destroy')->name('employees.delete')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/create', 'EmployeeController@create')->name('employees.create');
        Route::post('/', 'EmployeeController@store')->name('employees.store');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', 'UserController@index')->name('users.index');
        Route::get('/{id}/edit', 'UserController@edit')->name('users.edit')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}', 'UserController@update')->name('users.update')->where('id', '^[1-9][0-9]{0,9}$');
        Route::delete('/{id}', 'UserController@destroy')->name('users.delete')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/create', 'UserController@create')->name('users.create');
        Route::post('/', 'UserController@store')->name('users.store');
        Route::post('/password/reset', 'UserController@sendResetLinkToEmail')->name('users.reset_password');
    });
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('bookingsSumByDay', 'DashboardController@getBookingsSumByDay')->name('dashboard.bookings_sum_by_day');
});
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('account/confim/{token}', 'Auth\ConfirmationAccountController@index')->name('confirm.registration');
Route::post('account/confim/', 'Auth\ConfirmationAccountController@confirm')->name('confirm.submit');