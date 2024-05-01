@extends('layouts.header')
@section('booking_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/bookings-style.css'])
@endsection
@section('navbar_header_button')
<span class="header-navbar">Booking</span>
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="content-container">
        <section class="content">
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
                <div class="row">
                    <div class="col-md-8">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="ml-4"><b>Reservation info</b></h4>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush pl-3 pr-3">
                                            <!-- Room Number -->
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Room Number
                                                <!-- Link to room details -->
                                                @role('admin')
                                                <span class="badge bg-secondary badge-big">@isset($booking_data->rooms->room_number) <a href="{{ route('admin.rooms.show', $booking_data->rooms->id) }}">{{ $booking_data->rooms->room_number }}</a> @endisset</span>
                                                @endrole
                                                @role('receptionist')
                                                <span class="badge bg-secondary badge-big">@isset($booking_data->rooms->room_number) <a href="{{ route('receptionist.rooms.show', $booking_data->rooms->id) }}">{{ $booking_data->rooms->room_number }}</a> @endisset</span>
                                                @endrole
                                            </li>
                                            <!-- Room type -->
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Room type
                                                <span class="badge bg-secondary badge-big">@isset($booking_data->rooms->type) {{ ucfirst($booking_data->rooms->type) }} @endisset</span>
                                            </li>
                                            <!-- Adults -->
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Adults
                                                <span class="badge bg-secondary badge-big">{{ $booking_data->adults_count }}</span>
                                            </li>
                                            <!-- Children -->
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Children
                                                <span class="badge bg-secondary badge-big">{{ $booking_data->children_count }}</span>
                                            </li>
                                            <!-- Check-in Date -->
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Check-in Date
                                                <span class="badge bg-secondary badge-big">{{ \Carbon\Carbon::parse($booking_data->check_in_date)->format('d-m-Y') }}</span>
                                            </li>
                                            <!-- Check-out Date -->
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Check-out Date
                                                <span class="badge bg-secondary badge-big">{{ \Carbon\Carbon::parse($booking_data->check_out_date)->format('d-m-Y') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush pl-2 pr-2">
                                            <!-- Contact Number -->
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Contact Number
                                                <span class="badge bg-secondary badge-big">@isset($booking_data->guests[0]->phone_number) {{ $booking_data->guests[0]->phone_number }} @endisset</span>
                                            </li>
                                            <!-- Payment type -->
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Payment type
                                                <span class="badge bg-secondary badge-big">{{ ucfirst(str_replace('_', ' ', $booking_data->payment_type)) }}</span>
                                            </li>
                                            <!-- Total cost -->
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Total cost
                                                <span class="badge bg-secondary badge-big">{{ $booking_data->total_cost }}</span>
                                            </li>
                                            <!-- Status -->
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Status
                                                <!-- Dynamic badge class based on status -->
                                                @php
                                                $status = $booking_data->status;
                                                $badge_class = '';
                                                switch ($status) {
                                                case 'reserved':
                                                $badge_class = 'badge-secondary badge-big';
                                                break;
                                                case 'cancelled':
                                                $badge_class = 'badge-danger badge-big';
                                                break;
                                                case 'active':
                                                $badge_class = 'badge-success badge-big';
                                                break;
                                                case 'expired':
                                                $badge_class = 'badge-secondary badge-big';
                                                break;
                                                case 'completed':
                                                $badge_class = 'badge-success badge-big';
                                                break;
                                                default:
                                                $badge_class = 'badge-secondary badge-big';
                                                }
                                                @endphp
                                                <span class="badge badge-big {{ $badge_class }}">{{ ucfirst($status) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group list-group-flush pl-3 pr-3">
                                            <!-- Additional services -->
                                            <li class="list-group-item d-flex flex-column">
                                                <b>Additional services:</b>
                                                <!-- List of additional services -->
                                                @foreach ($booking_data->additional_services as $key => $service)
                                                {{ $service->name }}@if (!$loop->last)
                                                ,
                                                @endif
                                                @endforeach
                                            </li>
                                            <!-- Note -->
                                            <li class="list-group-item d-flex flex-column">
                                                <b>Note:</b>
                                                {{ ucfirst($booking_data->note) }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Booking controls -->
                    <div class="col-md-4">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="card-title"><b>Booking Controls</b></h4>
                                <div class="mb-3">
                                    <label for="statusSelect" class="form-label float-right">Change Status</label>
                                    <!-- Form for changing booking status -->
                                    @role('admin')
                                    <form id="statusForm" name="statusForm" action="{{ route('admin.booking.status', $booking_data->id) }}" method="POST">
                                    @endrole
                                    @role('receptionist')
                                    <form id="statusForm" name="statusForm" action="{{ route('receptionist.booking.status', $booking_data->id) }}" method="POST">
                                    @endrole   
                                    @csrf
                                        @method('PUT')
                                        <select class="form-select" id="statusSelect" name="status">
                                            <option value="reserved" {{ $booking_data->status === 'reserved' ? 'selected' : '' }}>Reserved</option>
                                            <option value="cancelled" {{ $booking_data->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            <option value="active" {{ $booking_data->status === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="expired" {{ $booking_data->status === 'expired' ? 'selected' : '' }}>Expired</option>
                                            <option value="completed" {{ $booking_data->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </form>
                                </div>
                                <!-- Edit reservation button -->
                                <div class="mb-3">
                                    @role('admin')
                                    <a href="{{ route('admin.booking.edit', $booking_data->id) }}" class="btn btn-primary w-100">Edit Reservation</a>
                                    @endrole
                                    @role('receptionist')
                                    <a href="{{ route('receptionist.booking.edit', $booking_data->id) }}" class="btn btn-primary w-100">Edit Reservation</a>
                                    @endrole
                                </div>
                                <!-- Delete reservation button -->
                                <div class="mb-3">
                                    @role('admin')
                                    <form action="{{ route('admin.booking.delete', $booking_data->id) }}" method="POST">
                                    @endrole    
                                    @role('receptionist')
                                    <form action="{{ route('receptionist.booking.delete', $booking_data->id) }}" method="POST">
                                    @endrole
                                    @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger w-100" type="submit">Delete Reservation</button>
                                    </form>
                                </div>
                                <!-- Relate guests button -->
                                @isset($booking_data->guests[0]->first_name)
                                <div class="mb-3">
                                    @role('admin')
                                    <a href="{{ route('admin.guests.create') }}" class="btn btn-secondary w-100">Relate guests</a>
                                    @endrole
                                    @role('receptionist')
                                    <a href="{{ route('receptionist.guests.create') }}" class="btn btn-secondary w-100">Relate guests</a>
                                    @endrole
                                </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <!-- Guests section -->
                    @isset($booking_data->guests[0]->first_name)
                    <div class="col-md-8">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="card-title pl-4"><b>Guests</b></h4>
                                <table class="table">
                                    <tr>
                                        <!-- First guest -->
                                        <td class="text-center"><b>
                                            @role('admin')
                                            <a href="{{ route('admin.guests.show', $booking_data->guests[0]->id) }}">
                                            @endrole
                                            @role('receptionist')
                                            <a href="{{ route('receptionist.guests.show', $booking_data->guests[0]->id) }}">
                                            @endrole
                                                {{ $booking_data->guests[0]->first_name }}
                                                {{ $booking_data->guests[0]->last_name }}</a></b></td>
                                        <!-- Second guest if available -->
                                        @if (count($booking_data->guests) > 1)
                                        <td class="text-center">
                                        @role('admin')
                                        <a href="{{ route('admin.guests.show', $booking_data->guests[1]->id) }}">
                                        @endrole
                                        @role('receptionist')
                                        <a href="{{ route('receptionist.guests.show', $booking_data->guests[1]->id) }}">
                                        @endrole
                                            {{ $booking_data->guests[1]->first_name }}
                                            {{ $booking_data->guests[1]->last_name }}</a>
                                        </td>
                                        @endif
                                    </tr>
                                    <!-- Display additional guests -->
                                    @if (count($booking_data->guests) > 2)
                                    @foreach ($booking_data->guests as $index => $guest)
                                    @if ($index >= 2)
                                    <tr>
                                        <td></td>
                                        @role('admin')
                                        <td class="text-center"><a href="{{ route('admin.guests.show', $booking_data->guests[$index]->id) }}">{{ $guest->first_name }}
                                        @endrole  
                                        @role('receptionist')
                                        <td class="text-center"><a href="{{ route('receptionist.guests.show', $booking_data->guests[$index]->id) }}">{{ $guest->first_name }}
                                        @endrole    
                                        {{ $guest->last_name }}</a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    @endisset
                </div>
            </div>
        </section>
    </div>
</div>
@section('custom-scripts')
@vite(['resources/js/booking/show.js'])
@endsection
@endsection