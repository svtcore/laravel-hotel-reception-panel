@extends('layouts.header')
@section('title', 'Booking search')
@section('booking_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/bookings-style.css'])
@endsection
@section('navbar_header_button')
<span id="header_booking_search">Booking search results</span>
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
                    <h4 class="font-weight-bold">Search form</h4>
                    <form id="searchForm" method="POST" action="{{ route(Auth::user()->hasRole('admin') ? 'admin.booking.search' : 'receptionist.booking.search') }}">
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
                                <input type="date" class="form-control" id="startDate" name="startDate" disabled value="{{ $inputData['startDate'] ?? \Carbon\Carbon::now()->toDateString() }}" required>
                            </div>
                            <div class="col-md-2 mb-2 mt-2 date-block">
                                <label for="endDate">End date</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" disabled value="{{ $inputData['endDate'] ?? \Carbon\Carbon::now()->toDateString() }}" required>
                            </div>
                            <div class="col-md-2 pt-2">
                                <label for="guestName">Guest name</label>
                                <input type="text" class="form-control" id="guestName" name="guestName" placeholder="Full name" disabled value="{{ $inputData['guestName'] ?? '' }}" minlength="2" maxlength="255" required>
                            </div>
                            <div class="col-md-2 pt-2">
                                <label for="roomNumber">Room number</label>
                                <input type="text" class="form-control" id="roomNumber" name="roomNumber" placeholder="Room number" value="{{ $inputData['roomNumber'] ?? '' }}" minlength="1" maxlength="3" required>
                            </div>
                            <div class="col-md-2 pt-2">
                                <label for="phoneNumber">Phone number</label>
                                <input type="number" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone number" disabled value="{{ $inputData['phoneNumber'] ?? '' }}" minlength="10" maxlength="15" required>
                            </div>
                            <div class="col-md-2 pt-4 mt-2">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <h4><b>Search results</b></h4>
                </div>
                <div id="events-container">
                    <table id="result-table" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">Room №</th>
                                <th>Guest name</th>
                                <th><i class="bi bi-people"></i></th>
                                <th>Room type</th>
                                <th>Phone number</th>
                                <th>Price</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th><i class="bi bi-calendar-week"></i></th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result as $booking)
                            <tr class="text-center">
                                <td class="text-center"><a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.rooms.show' : 'receptionist.rooms.show', $booking->rooms->id) }}">{{ $booking->rooms->room_number }}</a></td>
                                <td class="text-center">
                                    @isset($booking->guests[0]->first_name)
                                    <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.guests.show' : 'receptionist.guests.show', $booking->guests[0]->id) }}">
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
                                <td class="text-center">{{ ucfirst($booking->rooms->type) }}</td>
                                <td class="text-center">@isset($booking->guests[0]->phone_number) {{ $booking->guests[0]->phone_number }} @endisset</td>
                                <td class="text-center">{{ $booking->total_cost }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->diffInDays(\Carbon\Carbon::parse($booking->check_in_date), true) }}
                                </td>
                                <td class="text-center">
                                    @if ($booking->status == 'active' || $booking->status == 'completed')
                                    <span class="badge bg-success fs-6 pt-2 pb-2 w-100">{{ $booking->status }}</span>
                                    @elseif ($booking->status == 'cancelled')
                                    <span class="badge bg-danger fs-6 pt-2 pb-2 w-100">{{ $booking->status }}</span>
                                    @else
                                    <span class="badge bg-secondary fs-6 w-100 pt-2 pb-2">{{ $booking->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.booking.show' : 'receptionist.booking.show', $booking->id) }}" class="btn btn-secondary">Details</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-scripts')
@vite(['resources/js/booking/search.js'])
@endsection