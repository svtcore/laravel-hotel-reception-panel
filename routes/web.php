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

Route::get('/', 'HomeController@index')->name('home');

Route::middleware(['role:admin'])->group(function () {
    Route::namespace('admin')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::prefix('booking')->group(function () {
                Route::get('/{id}', 'BookingController@show')->name('admin.booking.show')->where('id', '^[1-9][0-9]{0,9}$');
                Route::get('/create/{room_id}', 'BookingController@create')->name('admin.booking.create')->where('id', '^[1-9][0-9]{0,9}$');
                Route::post('/store', 'BookingController@store')->name('admin.booking.store');
                Route::get('/{id}/edit', 'BookingController@edit')->name('admin.booking.edit')->where('id', '^[1-9][0-9]{0,9}$');
                Route::put('/{id}/edit/status', 'BookingController@changeStatus')->name('admin.booking.status')->where('id', '^[1-9][0-9]{0,9}$');
                Route::put('/{id}', 'BookingController@update')->name('admin.booking.update')->where('id', '^[1-9][0-9]{0,9}$');
                Route::delete('/{id}', 'BookingController@destroy')->name('admin.booking.delete')->where('id', '^[1-9][0-9]{0,9}$');
                Route::post('/search', 'BookingController@searchByParams')->name('admin.booking.search');
                Route::get('/', 'BookingController@index')->name('admin.booking.index');
            });
            Route::prefix('rooms')->group(function () {
                Route::post('/search', 'RoomController@searchByParams')->name('admin.rooms.search');
                Route::get('/{id}', 'RoomController@show')->name('admin.rooms.show')->where('id', '^[1-9][0-9]{0,9}$');
                Route::get('/{id}/edit', 'RoomController@edit')->name('admin.rooms.edit')->where('id', '^[1-9][0-9]{0,9}$');
                Route::put('/{id}', 'RoomController@update')->name('admin.rooms.update')->where('id', '^[1-9][0-9]{0,9}$');
                Route::delete('/{id}', 'RoomController@destroy')->name('admin.rooms.delete')->where('id', '^[1-9][0-9]{0,9}$');
                Route::get('/create', 'RoomController@create')->name('admin.rooms.create');
                Route::post('/', 'RoomController@store')->name('admin.rooms.store');
                Route::get('/', 'RoomController@index')->name('admin.rooms.index');
                Route::prefix('properties')->group(function () {
                    Route::get('/', 'RoomPropertyController@index')->name('admin.rooms.properties.index');
                    Route::get('/create', 'RoomPropertyController@create')->name('admin.rooms.properties.create');
                    Route::post('/', 'RoomPropertyController@store')->name('admin.rooms.properties.store');
                    Route::get('/{id}/edit', 'RoomPropertyController@edit')->name('admin.rooms.properties.edit')->where('id', '^[1-9][0-9]{0,9}$');
                    Route::put('/{id}', 'RoomPropertyController@update')->name('admin.rooms.properties.update')->where('id', '^[1-9][0-9]{0,9}$');
                    Route::delete('/{id}', 'RoomPropertyController@destroy')->name('admin.rooms.properties.delete')->where('id', '^[1-9][0-9]{0,9}$');
                });
            });
            Route::prefix('guests')->group(function () {
                Route::get('/', 'GuestController@index')->name('admin.guests.index');
                Route::get('/{id}/edit', 'GuestController@edit')->name('admin.guests.edit')->where('id', '^[1-9][0-9]{0,9}$');
                Route::put('/{id}', 'GuestController@update')->name('admin.guests.update')->where('id', '^[1-9][0-9]{0,9}$');
                Route::get('/{id}', 'GuestController@show')->name('admin.guests.show')->where('id', '^[1-9][0-9]{0,9}$');
                Route::delete('/{id}', 'GuestController@destroy')->name('admin.guests.delete')->where('id', '^[1-9][0-9]{0,9}$');
                Route::get('/create', 'GuestController@create')->name('admin.guests.create');
                Route::post('/', 'GuestController@store')->name('admin.guests.store');
                Route::post('/search', 'GuestController@searchByParams')->name('admin.guests.search');
                Route::post('/create/relation/', 'GuestController@relation')->name('admin.guests.relation');
                Route::post('/relation/search', 'GuestController@searchRelation')->name('admin.guests.search.relation');
                Route::post('/relation/submit', 'GuestController@submitRelation')->name('admin.guests.relation.submit');
                Route::delete('/relation/delete', 'GuestController@deleteRelation')->name('admin.guests.relation.delete');
                
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
            Route::prefix('services')->group(function () {
                Route::get('/', 'AdditionalServiceController@index')->name('admin.services.index');
                Route::post('/', 'AdditionalServiceController@store')->name('admin.services.store');
                Route::get('/create', 'AdditionalServiceController@create')->name('admin.services.create');
                Route::get('/{id}/edit', 'AdditionalServiceController@edit')->name('admin.services.edit')->where('id', '^[1-9][0-9]{0,9}$');
                Route::put('/{id}', 'AdditionalServiceController@update')->name('admin.services.update')->where('id', '^[1-9][0-9]{0,9}$');
                Route::delete('/{id}', 'AdditionalServiceController@destroy')->name('admin.services.delete')->where('id', '^[1-9][0-9]{0,9}$');
            });
            Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
        });
    });
});
Route::middleware(['role:receptionist'])->group(function () {
    Route::namespace('receptionist')->group(function () {
        Route::prefix('booking')->group(function () {
            Route::get('/', 'BookingController@index')->name('receptionist.booking.index');
            Route::get('/{id}', 'BookingController@show')->name('receptionist.booking.show')->where('id', '^[1-9][0-9]{0,9}$');
            Route::get('/create/{room_id}', 'BookingController@create')->name('receptionist.booking.create')->where('id', '^[1-9][0-9]{0,9}$');
            Route::post('/store', 'BookingController@store')->name('receptionist.booking.store');
            Route::get('/{id}/edit', 'BookingController@edit')->name('receptionist.booking.edit')->where('id', '^[1-9][0-9]{0,9}$');
            Route::put('/{id}/edit/status', 'BookingController@changeStatus')->name('receptionist.booking.status')->where('id', '^[1-9][0-9]{0,9}$');
            Route::put('/{id}', 'BookingController@update')->name('receptionist.booking.update')->where('id', '^[1-9][0-9]{0,9}$');
            Route::delete('/{id}', 'BookingController@destroy')->name('receptionist.booking.delete')->where('id', '^[1-9][0-9]{0,9}$');
            Route::post('/search', 'BookingController@searchByParams')->name('receptionist.booking.search');
        });

        Route::prefix('rooms')->group(function () {
            Route::get('/', 'RoomController@index')->name('receptionist.rooms.index');
            Route::post('/search', 'RoomController@searchByParams')->name('receptionist.rooms.search');
            Route::get('/{id}', 'RoomController@show')->name('receptionist.rooms.show')->where('id', '^[1-9][0-9]{0,9}$');
        });

        Route::prefix('guests')->group(function () {
            Route::get('/', 'GuestController@index')->name('receptionist.guests.index');
            Route::get('/{id}/edit', 'GuestController@edit')->name('receptionist.guests.edit')->where('id', '^[1-9][0-9]{0,9}$');
            Route::put('/{id}', 'GuestController@update')->name('receptionist.guests.update')->where('id', '^[1-9][0-9]{0,9}$');
            Route::get('/{id}', 'GuestController@show')->name('receptionist.guests.show')->where('id', '^[1-9][0-9]{0,9}$');
            Route::delete('/{id}', 'GuestController@destroy')->name('receptionist.guests.delete')->where('id', '^[1-9][0-9]{0,9}$');
            Route::get('/create', 'GuestController@create')->name('receptionist.guests.create');
            Route::post('/', 'GuestController@store')->name('receptionist.guests.store');
            Route::post('/search', 'GuestController@searchByParams')->name('receptionist.guests.search');
            Route::post('/create/relation/', 'GuestController@relation')->name('receptionist.guests.relation');
            Route::post('/relation/search', 'GuestController@searchRelation')->name('receptionist.guests.search.relation');
            Route::post('/relation/submit', 'GuestController@submitRelation')->name('receptionist.guests.relation.submit');
            Route::delete('/relation/delete', 'GuestController@deleteRelation')->name('receptionist.guests.relation.delete');
        });

        Route::prefix('employees')->group(function () {
            Route::get('/', 'EmployeeController@index')->name('receptionist.employees.index');
        });
    });
});
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('account/confim/{token}', 'Auth\ConfirmationAccountController@index')->name('confirm.registration');
Route::post('account/confim/', 'Auth\ConfirmationAccountController@confirm')->name('confirm.submit');


Auth::routes();
