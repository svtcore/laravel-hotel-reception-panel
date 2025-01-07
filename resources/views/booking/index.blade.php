@extends('layouts.header')
@section('title', 'Booking')
@section('booking_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/bookings-style.css'])
@endsection
@section('navbar_header_button')
<span id="header_booking">Booking</span>
@endsection
@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <div class="content-header">
            <div class="container-fluid">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if ($errors->any())
                <div class="custom-error-message">
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="content-container text-center">
                    <h4><b>Search form</b></h4>
                    <form id="searchForm" method="POST" action="{{ route(auth()->user()->hasRole('admin') ? 'admin.booking.search' : (auth()->user()->hasRole('receptionist') ? 'receptionist.booking.search' : '#')) }}">
                        @csrf
                        <div class="row mt-5">
                            <div class="col-md-4">
                                <label class="toggle">
                                    <input class="toggle-checkbox" id="switch-by-date" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label">By date</span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="toggle">
                                    <input class="toggle-checkbox" id="switch-by-name" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label">By guest</span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="toggle" checked>
                                    <input class="toggle-checkbox" id="switch-by-room" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label">By room</span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="toggle">
                                    <input class="toggle-checkbox" id="switch-by-phone" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label">By phone</span>
                                </label>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-2 mt-2 date-block">
                                <label for="startDate">Start date</label>
                                <input type="date" class="form-control text-center @error('startDate') is-invalid @enderror" id="startDate" name="startDate" disabled value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                            </div>
                            <div class="col-md-2 mb-2 mt-2 date-block">
                                <label for="endDate">End date</label>
                                <input type="date" class="form-control text-center @error('endDate') is-invalid @enderror" id="endDate" name="endDate" disabled value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                            </div>
                            <div class="col-md-2 pt-2">
                                <label for="guestName">Guest name</label>
                                <input type="text" class="form-control text-center @error('guestName') is-invalid @enderror" id="guestName" name="guestName" disabled placeholder="Full name" minlength="2" maxlength="255" required>
                                <div class="invalid-feedback">
                                    Please provide a valid guest name.
                                </div>
                            </div>
                            <div class="col-md-2 pt-2">
                                <label for="roomNumber">Room number</label>
                                <input type="text" class="form-control text-center @error('roomNumber') is-invalid @enderror" id="roomNumber" name="roomNumber" placeholder="Room number" required minlength="1" maxlength="3" required>
                                <div class="invalid-feedback">
                                    Please provide a valid room number.
                                </div>
                            </div>
                            <div class="col-md-2 pt-2">
                                <label for="phoneNumber">Phone number</label>
                                <input type="number" class="form-control text-center @error('phoneNumber') is-invalid @enderror" id="phoneNumber" name="phoneNumber" placeholder="Phone number" disabled minlength="10" maxlength="15" required>
                                <div class="invalid-feedback">
                                    Please provide a valid phone number.
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="searchButton"></label>
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <h4><b>Events for today</b></h4>
                </div>
                <div id="events-container">
                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="checkIn-tab" data-bs-toggle="tab" href="#checkIn" role="tab" aria-controls="checkIn" aria-selected="true">Check-In
                                @if (count($check_in_bookings) > 0)
                                <span class="badge bg-primary">{{ count($check_in_bookings) }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="checkOut-tab" data-bs-toggle="tab" href="#checkOut" role="tab" aria-controls="checkOut" aria-selected="false">Check-Out
                                @if (count($check_out_bookings) > 0)
                                <span class="badge bg-primary">{{ count($check_out_bookings) }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2">
                        <div class="tab-pane fade show active" id="checkIn" role="tabpanel" aria-labelledby="checkIn-tab">
                            <table id="check-in-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center">Room №</th>
                                        <th>Guest name</th>
                                        <th><i class="bi bi-people"></i></th>
                                        <th>Phone number</th>
                                        <th>Price</th>
                                        <th>Check-In</th>
                                        <th>Check-Out</th>
                                        <th><i class="bi bi-calendar-week"></i></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($check_in_bookings))
                                        @foreach ($check_in_bookings as $booking)
                                        <tr class="text-center">
                                            <td class="text-center">
                                                <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.rooms.show' : (Auth::user()->hasRole('receptionist') ? 'receptionist.rooms.show' : '#'), $booking->room_id) }}">
                                                    {{ $booking->rooms->room_number ?? '' }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                @isset($booking->guests[0])
                                                <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.guests.show' : (Auth::user()->hasRole('receptionist') ? 'receptionist.guests.show' : '#'), $booking->guests[0]->id) }}">
                                                    {{ $booking->guests[0]->first_name }} {{ $booking->guests[0]->last_name }}
                                                </a>
                                                @endisset
                                            </td>
                                            <td class="text-center">
                                                <b>{{ $booking->adults_count }}</b>
                                                @if ($booking->children_count > 0)
                                                <span class="badge badge-success badge-big"><i class="fa-solid fa-baby"></i></span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $booking->guests[0]->phone_number ?? '' }}</td>
                                            <td class="text-center">{{ $booking->total_cost }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d-m-Y') }}
                                            </td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d-m-Y') }}
                                            </td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($booking->check_out_date)->diffInDays(\Carbon\Carbon::parse($booking->check_in_date), true) }}
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route(Auth::user()->hasRole('admin') ? 'admin.booking.delete' : (Auth::user()->hasRole('receptionist') ? 'receptionist.booking.delete' : '#'), $booking->id) }}" method="POST">
                                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                                        <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.booking.show' : (Auth::user()->hasRole('receptionist') ? 'receptionist.booking.show' : '#'), $booking->id) }}" class="btn btn-secondary">Details</a>
                                                        <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.booking.edit' : (Auth::user()->hasRole('receptionist') ? 'receptionist.booking.edit' : '#'), $booking->id) }}" type="button" class="btn btn-warning">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="checkOut" role="tabpanel" aria-labelledby="checkOut-tab">
                            <table id="check-out-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Room №</th>
                                        <th>Guest name</th>
                                        <th>Persons</th>
                                        <th>Phone number</th>
                                        <th>Price</th>
                                        <th>Check-Out</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($check_out_bookings))
                                        @foreach ($check_out_bookings as $booking)
                                        <tr>
                                            <td class="text-center">
                                                @isset($booking->rooms->room_number)
                                                <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.rooms.show' : 'receptionist.rooms.show', $booking->room_id) }}">
                                                    {{ $booking->rooms->room_number }}
                                                </a>
                                                @endisset
                                            </td>
                                            <td class="text-center">
                                                @isset($booking->guests[0])
                                                {{ $booking->guests[0]->first_name }} {{ $booking->guests[0]->last_name }}
                                                @endisset
                                            </td>
                                            <td class="text-center">
                                                <b>{{ $booking->adults_count }}</b>
                                                @if ($booking->children_count > 0)
                                                <span class="badge badge-success badge-big">
                                                    <i class="fa-solid fa-baby"></i>
                                                </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $booking->guests[0]->phone_number ?? '' }}
                                            </td>
                                            <td class="text-center">{{ $booking->total_cost }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d-m-Y') }}
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route(Auth::user()->hasRole('admin') ? 'admin.booking.status' : 'receptionist.booking.status', $booking->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                                        <input type="hidden" name="status" value="completed" />
                                                        <button type="submit" class="btn btn-success">Complete check-out</button>
                                                        <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.booking.edit' : 'receptionist.booking.edit', $booking->id) }}" class="btn btn-warning">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-scripts')
@vite(['resources/js/booking/index.js'])
@endsection