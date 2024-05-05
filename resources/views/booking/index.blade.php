@extends('layouts.header')
@section('booking_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/bookings-style.css'])
@endsection
@section('navbar_header_button')
<span class="header-navbar">Booking</span>
@endsection
@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <div class="content-header">
            <div class="container-fluid mt-4">
                <!-- Success message -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <!-- Error messages -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="content-container text-center">
                    <h4 class="font-weight-bold">Search form</h4>
                    <!-- Form for searching bookings -->
                    @role('admin')
                    <form id="searchForm" method="POST" action="{{ route('admin.booking.search') }}">
                        @endrole
                        @role('receptionist')
                        <form id="searchForm" method="POST" action="{{ route('receptionist.booking.search') }}">
                            @endrole
                            @csrf
                            <div class="row mt-5">
                                <!-- Toggle switches for search options -->
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
                            <div class="form-row">
                                <!-- Search inputs -->
                                <div class="col-md-2 mb-2 mt-2 date-block">
                                    <label for="startDate">Start date</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate" disabled value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                </div>
                                <div class="col-md-2 mb-2 mt-2 date-block">
                                    <label for="endDate">End date</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate" disabled value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                </div>
                                <div class="col-md-2 pt-2">
                                    <label for="guestName">Guest name</label>
                                    <input type="text" class="form-control" id="guestName" name="guestName" disabled placeholder="Full name" minlength="2" maxlength="255" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid guest name.
                                    </div>
                                </div>
                                <div class="col-md-2 pt-2">
                                    <label for="roomNumber">Room number</label>
                                    <input type="text" class="form-control" id="roomNumber" name="roomNumber" placeholder="Room number" required minlength="1" maxlength="3">
                                    <div class="invalid-feedback">
                                        Please provide a valid room number.
                                    </div>
                                </div>
                                <div class="col-md-2 pt-2">
                                    <label for="phoneNumber">Phone number</label>
                                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone number" disabled required minlength="10" maxlength="15">
                                    <div class="invalid-feedback">
                                        Please provide a valid phone number.
                                    </div>
                                </div>
                                <div class="col-md-2 pt-2 mt-2">
                                    <label for="phoneNumber"></label>
                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                </div>
                            </div>
                        </form>
                </div>
                <div class="mt-4 text-center">
                    <h4><b>Events for today</b></h4>
                </div>
                <div id="chat-container">
                    <!-- Tabs for check-in and check-out -->
                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="checkIn-tab" data-bs-toggle="tab" href="#checkIn" role="tab" aria-controls="checkIn" aria-selected="true">Check-In
                                <!-- Badge for check-in count -->
                                @if (count($check_in_bookings) > 0)
                                <span class="badge bg-primary">{{ count($check_in_bookings) }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="checkOut-tab" data-bs-toggle="tab" href="#checkOut" role="tab" aria-controls="checkOut" aria-selected="false">Check-Out
                                <!-- Badge for check-out count -->
                                @if (count($check_out_bookings) > 0)
                                <span class="badge bg-primary">{{ count($check_out_bookings) }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-2">
                        <div class="tab-pane fade show active" id="checkIn" role="tabpanel" aria-labelledby="checkIn-tab">
                            <!-- Table for check-in bookings -->
                            <table id="check-in-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center">Room №</th>
                                        <th>Guest name</th>
                                        <th>Persons</th>
                                        <th>Phone number</th>
                                        <th>Price</th>
                                        <th>Check-In</th>
                                        <th>Check-Out</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Loop through check-in bookings -->
                                    @foreach ($check_in_bookings as $booking)
                                    <tr class="text-center">
                                        <!-- Link to room details -->
                                        @role('admin')
                                        <td class="text-center"><a href="{{ route('admin.rooms.show', $booking->room_id) }}">@isset($booking->rooms->room_number) {{ $booking->rooms->room_number }} @endisset</a></td>
                                        @endrole
                                        @role('receptionist')
                                        <td class="text-center"><a href="{{ route('receptionist.rooms.show', $booking->room_id) }}">@isset($booking->rooms->room_number) {{ $booking->rooms->room_number }} @endisset</a></td>
                                        @endrole
                                        <!-- Guest name -->
                                        <td class="text-center">
                                            @isset($booking->guests[0]->first_name)
                                            {{ $booking->guests[0]->first_name }}
                                            {{ $booking->guests[0]->last_name }}
                                            @endisset
                                        </td>
                                        <!-- Number of persons -->
                                        <td class="text-center"><b>{{ $booking->adults_count }}</b> @if ($booking->children_count > 0)
                                            <span class="badge badge-success badge-big"><i class="fa-solid fa-baby"></i></span>
                                            @endif
                                        </td>
                                        <!-- Guest phone number -->
                                        <td class="text-center">@isset($booking->guests[0]->phone_number) {{ $booking->guests[0]->phone_number }} @endisset</td>
                                        <!-- Booking price -->
                                        <td class="text-center">{{ $booking->total_cost }}</td>
                                        <!-- Check-in date -->
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d-m-Y') }}
                                        </td>
                                        <!-- Check-out date -->
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d-m-Y') }}
                                        </td>
                                        <!-- Action buttons -->
                                        <td class="text-center">
                                            @role('admin')
                                            <form action="{{ route('admin.booking.delete', $booking->id) }}" method="POST">
                                                @endrole
                                                @role('receptionist')
                                                <form action="{{ route('receptionist.booking.delete', $booking->id) }}" method="POST">
                                                    @endrole
                                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                                        <!-- Details button -->
                                                        @role('admin')
                                                        <a href="{{ route('admin.booking.show', $booking->id) }}" class="btn btn-secondary">Details
                                                        </a>
                                                        <!-- Edit button -->
                                                        <a href="{{ route('admin.booking.edit', $booking->id) }}" type="button" class="btn btn-warning">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        @endrole
                                                        @role('receptionist')
                                                        <a href="{{ route('receptionist.booking.show', $booking->id) }}" class="btn btn-secondary">Details
                                                        </a>
                                                        <a href="{{ route('receptionist.booking.edit', $booking->id) }}" type="button" class="btn btn-warning">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        @endrole
                                                        @csrf
                                                        @method('DELETE')
                                                        <!-- Delete button -->
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="checkOut" role="tabpanel" aria-labelledby="checkOut-tab">
                            <!-- Table for check-out bookings -->
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
                                    <!-- Loop through check-out bookings -->
                                    @foreach ($check_out_bookings as $booking)
                                    <tr>
                                        <!-- Link to room details -->
                                        @role('admin')
                                        <td class="text-center">@isset($booking->rooms->room_number) <a href="{{ route('admin.rooms.show', $booking->room_id) }}">{{ $booking->rooms->room_number }}</a>@endisset</td>
                                        @endrole
                                        @role('receptionist')
                                        <td class="text-center">@isset($booking->rooms->room_number) <a href="{{ route('receptionist.rooms.show', $booking->room_id) }}">{{ $booking->rooms->room_number }}</a>@endisset</td>
                                        @endrole
                                        <!-- Guest name -->
                                        <td class="text-center">
                                            @isset($booking->guests[0]->first_name)
                                            {{ $booking->guests[0]->first_name }}
                                            {{ $booking->guests[0]->last_name }}
                                            @endisset
                                        </td>
                                        <!-- Number of persons -->
                                        <td class="text-center"><b>{{ $booking->adults_count }}</b> @if ($booking->children_count > 0)
                                            <span class="badge badge-success badge-big"><i class="fa-solid fa-baby"></i></span>
                                            @endif
                                        </td>
                                        <!-- Guest phone number -->
                                        <td class="text-center">@isset($booking->guests[0]->phone_number) {{ $booking->guests[0]->phone_number }} @endisset</td>
                                        <!-- Booking price -->
                                        <td class="text-center">{{ $booking->total_cost }}</td>
                                        <!-- Check-out date -->
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d-m-Y') }}
                                        </td>
                                        <!-- Action buttons -->
                                        <td class="text-center">
                                            @role('admin')
                                            <form action="{{ route('admin.booking.status', $booking->id) }}" method="POST">
                                                @endrole
                                                @role('receptionist')
                                                <form action="{{ route('receptionist.booking.status', $booking->id) }}" method="POST">
                                                    @endrole
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                                        <!-- Complete check-out button -->
                                                        <input type="hidden" value="completed" name="status" />
                                                        <button type="submit" class="btn btn-success">Complete
                                                            check-out</i></button>
                                                        <!-- Edit button -->
                                                        @role('admin')
                                                        <a href="{{ route('admin.booking.edit', $booking->id) }}" type="submit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                                        @endrole
                                                        @role('receptionist')
                                                        <a href="{{ route('receptionist.booking.edit', $booking->id) }}" type="submit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                                        @endrole
                                                    </div>
                                                </form>
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
    </div>
</div>
@section('custom-scripts')
@vite(['resources/js/booking/index.js'])
@endsection
@endsection