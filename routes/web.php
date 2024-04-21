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
        Route::post('/search', 'BookingController@searchByParams')->name('admin.booking.search');
        Route::get('/', 'BookingController@index')->name('admin.booking.index');
        Route::get('/{id}', 'BookingController@show')->name('admin.booking.show')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/{id}/edit', 'BookingController@edit')->name('admin.booking.edit')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}', 'BookingController@update')->name('admin.booking.update')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}/edit/status', 'BookingController@changeStatus')->name('admin.booking.status')->where('id', '^[1-9][0-9]{0,9}$');
        Route::delete('/{id}', 'BookingController@destroy')->name('admin.booking.delete')->where('id', '^[1-9][0-9]{0,9}$');
    });
    Route::prefix('rooms')->group(function () {
        Route::get('/', 'RoomController@index')->name('admin.rooms.index');
        Route::post('/search', 'RoomController@searchByParams')->name('admin.rooms.search');
        Route::get('/{id}', 'RoomController@show')->name('admin.rooms.show')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/{id}/edit', 'RoomController@edit')->name('admin.rooms.edit')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}', 'RoomController@update')->name('admin.rooms.update')->where('id', '^[1-9][0-9]{0,9}$');
        Route::delete('/{id}', 'RoomController@destroy')->name('admin.rooms.delete')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/create', 'RoomController@create')->name('admin.rooms.create');
        Route::post('/', 'RoomController@store')->name('admin.rooms.store');
    });
    Route::prefix('guests')->group(function () {
        Route::get('/', 'GuestController@index')->name('admin.guests.index');
        Route::get('/{id}/edit', 'GuestController@edit')->name('admin.guests.edit')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}', 'GuestController@update')->name('admin.guests.update')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/{id}', 'GuestController@show')->name('admin.guests.show')->where('id', '^[1-9][0-9]{0,9}$');
        Route::delete('/{id}', 'GuestController@destroy')->name('admin.guests.delete')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/create', 'GuestController@create')->name('admin.guests.create');
        Route::post('/create/relation/', 'GuestController@relation')->name('admin.guests.relation');
        Route::post('/', 'GuestController@store')->name('admin.guests.store');
        Route::post('/search', 'GuestController@searchByParams')->name('admin.guests.search');
    });

    Route::prefix('employees')->group(function () {
        Route::get('/', 'EmployeeController@index')->name('admin.employees.index');
        Route::get('/{id}/edit', 'EmployeeController@edit')->name('admin.employees.edit')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}', 'EmployeeController@update')->name('admin.employees.update')->where('id', '^[1-9][0-9]{0,9}$');
        Route::delete('/{id}', 'EmployeeController@destroy')->name('admin.employees.delete')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/create', 'EmployeeController@create')->name('admin.employees.create');
        Route::post('/', 'EmployeeController@store')->name('admin.employees.store');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', 'UserController@index')->name('admin.users.index');
        Route::get('/{id}/edit', 'UserController@edit')->name('admin.users.edit')->where('id', '^[1-9][0-9]{0,9}$');
        Route::put('/{id}', 'UserController@update')->name('admin.users.update')->where('id', '^[1-9][0-9]{0,9}$');
        Route::delete('/{id}', 'UserController@destroy')->name('admin.users.delete')->where('id', '^[1-9][0-9]{0,9}$');
        Route::get('/create', 'UserController@create')->name('admin.users.create');
        Route::post('/', 'UserController@store')->name('admin.users.store');
        Route::post('/password/reset', 'UserController@sendResetLinkToEmail')->name('admin.users.reset_password');
    });
});
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('account/confim/{token}', 'Auth\ConfirmationAccountController@index')->name('confirm.registration');
Route::post('account/confim/', 'Auth\ConfirmationAccountController@confirm')->name('confirm.submit');