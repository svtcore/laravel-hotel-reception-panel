@extends('layouts.header')

@section('rooms_navbar_state', 'active')

@section('additional_style')
@vite(['resources/css/rooms-style.css'])
@endsection

@section('navbar_header_button')
@role('admin')
<a href="{{ route('admin.rooms.create') }}" class="add-new-button">Add room</a>
@endrole
@role('receptionist')
<span class="header-navbar">Rooms</span>
@endrole
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

                <div id="main-container">
                    <div class="content-container text-center">
                        <div class="room-info-table">
                            <h4 class="mb-4"><b>Room Information</b></h4>

                            @if (isset($room->deleted_at))
                            <div class="row pl-4 mt-2 mb-2 pr-4">
                                <div class="col-md-12">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-center align-items-center">
                                            <span class="badge bg-danger badge-big fs-7">This room has been deleted and no longer available</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @endif

                            <div class="row pl-4 pr-4">
                                <div class="{{ isset($room->deleted_at) ? 'col-md-6' : 'col-md-4' }}">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Room number
                                            <span class="badge bg-secondary badge-big fs-7">{{ $room->room_number }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Type
                                            <span class="badge bg-secondary badge-big fs-7">{{ ucfirst($room->type) }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Floor
                                            <span class="badge bg-secondary badge-big fs-7">{{ $room->floor_number }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Total rooms
                                            <span class="badge bg-secondary badge-big fs-7">{{ $room->total_rooms }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="{{ isset($room->deleted_at) ? 'col-md-6' : 'col-md-4' }}">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Adults beds
                                            <span class="badge bg-secondary badge-big fs-7">{{ $room->adults_beds_count }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Children beds
                                            <span class="badge bg-secondary badge-big fs-7">{{ $room->children_beds_count }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Price per Night
                                            <span class="badge bg-secondary badge-big fs-7">{{ $room->price }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Current Status
                                            <span class="badge bg-{{ $room->status === 'available' ? 'success' : ($room->status === 'occupied' ? 'danger' : 'secondary') }} badge-big fs-6">
                                                {{ ucfirst($room->status) }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>

                                @if (!isset($room->deleted_at))
                                <div class="col-md-4">
                                    <div class="card no-shadow">
                                        <div class="card-body">
                                            <h5 class="mb-2"><b>Room control</b></h5>
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a href="{{ (auth()->user()->hasRole('admin')) ? route('admin.booking.create', $room->id) : (auth()->user()->hasRole('receptionist') ? route('receptionist.booking.create', $room->id) : '#') }}" class="btn btn-success w-100">Book this room</a>
                                                </li>
                                                @if(auth()->user()->hasRole('admin'))
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning w-100">Edit room</a>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <form action="{{ route('admin.rooms.delete', $room->id) }}" method="POST" class="w-100">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger w-100" type="submit">Delete room</button>
                                                    </form>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if (count($room->room_properties) > 0)
                            <h5 class="{{ count($room->room_properties) < 3 ? 'text-left pl-5' : 'text-center' }} mt-4"><b>Additional properties</b></h5>
                            <div class="row pl-4 pr-4 mt-4">
                                @foreach($room->room_properties as $key => $property)
                                @if($key % 2 == 0)
                                <div class="col-md-4">
                                    <div class="additional-amenities">
                                        <ul class="list-group">
                                            @endif
                                            <li class="list-group-item d-flex justify-content-between align-items-center rounded-0">
                                                <span class="text-center">{{ $property->name }}</span>
                                                <span class="badge bg-success big-badge"><i class="fas fa-check"></i></span>
                                            </li>
                                            @if($key % 2 != 0 || $loop->last)
                                        </ul>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="content-container text-center mt-4 pl-5 pr-5">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="available-dates-tab" data-bs-toggle="tab" href="#available-dates" role="tab" aria-controls="available-dates" aria-selected="true">
                                    Available Dates
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="booking-tab" data-bs-toggle="tab" href="#booking" role="tab" aria-controls="booking" aria-selected="false">
                                    Booking History
                                    <span class="badge bg-primary">{{ count($booking) }}</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="available-dates" role="tabpanel" aria-labelledby="available-dates-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Date Check In</th>
                                            <th class="text-center">Date Check Out</th>
                                            <th class="text-center">Amount of Days</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($available_dates))
                                        @foreach($available_dates[0] as $range)
                                        @php
                                        $dates = explode(' — ', $range);
                                        $checkIn = date('d-m-Y', strtotime($dates[0]));
                                        $checkOut = date('d-m-Y', strtotime($dates[1]));
                                        $amountOfDays = (strtotime($checkOut) - strtotime($checkIn)) / (60 * 60 * 24);
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $checkIn }}</td>
                                            <td class="text-center">{{ $checkOut }}</td>
                                            <td class="text-center">{{ $amountOfDays }} days</td>
                                            <td class="text-center">
                                                <a href="{{ auth()->user()->hasRole('admin') ? route('admin.booking.create', $room->id) : (auth()->user()->hasRole('receptionist') ? route('receptionist.booking.create', $room->id) : '#') }}" class="btn btn-success w-100">Book now</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            @php
                                            $checkIn = date('d-m-Y', strtotime($available_dates[1]));
                                            $checkOut = 'Any';
                                            @endphp
                                            <td class="text-center">{{ $checkIn }}</td>
                                            <td class="text-center">{{ $checkOut }}</td>
                                            <td class="text-center">Any</td>
                                            <td class="text-center">
                                                <a href="{{ auth()->user()->hasRole('admin') ? route('admin.booking.create', $room->id) : (auth()->user()->hasRole('receptionist') ? route('receptionist.booking.create', $room->id) : '#') }}" class="btn btn-success w-100">Book now</a>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="booking" role="tabpanel" aria-labelledby="booking-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Guest Name</th>
                                            <th class="text-center">Related</th>
                                            <th class="text-center">Check-in Date</th>
                                            <th class="text-center">Check-out Date</th>
                                            <th class="text-center">Total Price</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($booking as $book)
                                        @php
                                        $date_check_in = date('d-m-Y', strtotime($book->check_in_date));
                                        $date_check_out = date('d-m-Y', strtotime($book->check_out_date));
                                        @endphp
                                        <tr>
                                            <td class="text-center">
                                                <a href="{{ route('receptionist.guests.show', $book->guests[0]->id) }}">
                                                    {{ $book->guests[0]->first_name }} {{ $book->guests[0]->last_name }}
                                                </a>
                                            </td>
                                            <td class="text-center">{{ count($book->guests) }}</td>
                                            <td class="text-center">{{ $date_check_in }}</td>
                                            <td class="text-center">{{ $date_check_out }}</td>
                                            <td class="text-center">{{ $book->total_cost }}</td>
                                            <td class="text-center">
                                                <span class="badge 
                                                        @if ($book->status == 'active' || $book->status == 'completed') bg-success 
                                                        @elseif ($book->status == 'canceled') bg-danger 
                                                        @else bg-secondary @endif badge-big fs-6 w-100">
                                                    {{ $book->status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ auth()->user()->hasRole('admin') ? route('admin.booking.delete', $book->id) : route('receptionist.booking.delete', $book->id) }}" method="POST">
                                                    <a href="{{ auth()->user()->hasRole('admin') ? route('admin.booking.show', $book->id) : route('receptionist.booking.show', $book->id) }}" class="btn btn-secondary fs-6">Details</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger fs-6" type="submit"><i class="bi bi-trash3"></i></button>
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
</div>
@endsection

@section('custom-scripts')
@vite(['resources/js/rooms/show.js'])
@endsection