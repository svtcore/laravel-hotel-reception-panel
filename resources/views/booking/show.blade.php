@extends('layouts.header')
@section('title', 'Booking information')
@section('booking_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/bookings-style.css'])
@endsection
@section('navbar_header_button')
<span id="header_booking_show">Booking details</span>
@endsection
@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <section class="content">
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
                <div class="row">
                    <div class="col-md-8">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="ml-4"><b>Booking information</b></h4>
                                <hr />
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush pl-3 pr-3">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Room Number:
                                                <span class="badge bg-secondary badge-big fs-7">
                                                    @isset($booking_data->rooms->room_number)
                                                    <a id="room-number-link" href="{{ route(Auth::user()->hasRole('admin') ? 'admin.rooms.show' : 'receptionist.rooms.show', $booking_data->rooms->id) }}">
                                                        {{ $booking_data->rooms->room_number }}
                                                    </a>
                                                    @endisset
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Room type:
                                                <span class="badge bg-secondary badge-big fs-7">@isset($booking_data->rooms->type) {{ ucfirst($booking_data->rooms->type) }} @endisset</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Adults:
                                                <span class="badge bg-secondary badge-big fs-7">{{ $booking_data->adults_count }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Children:
                                                <span class="badge bg-secondary badge-big fs-7">{{ $booking_data->children_count }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Check-in Date:
                                                <span class="badge bg-secondary badge-big fs-7">{{ \Carbon\Carbon::parse($booking_data->check_in_date)->format('d-m-Y') }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Check-out Date:
                                                <span class="badge bg-secondary badge-big fs-7">{{ \Carbon\Carbon::parse($booking_data->check_out_date)->format('d-m-Y') }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Days:
                                                <span class="badge bg-secondary badge-big fs-7">{{ \Carbon\Carbon::parse($booking_data->check_out_date)->diffInDays(\Carbon\Carbon::parse($booking_data->check_in_date), true) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush pl-2 pr-2">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Contact Number:
                                                <span class="badge bg-secondary badge-big fs-7">@isset($booking_data->guests[0]->phone_number) {{ $booking_data->guests[0]->phone_number }} @endisset</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Payment type:
                                                <span class="badge bg-secondary badge-big fs-7">{{ ucfirst(str_replace('_', ' ', $booking_data->payment_type)) }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Total cost:
                                                <span class="badge bg-secondary badge-big fs-7">{{ $booking_data->total_cost }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Status:
                                                @php
                                                $status = $booking_data->status;
                                                $badge_class = '';
                                                switch ($status) {
                                                case 'reserved':
                                                $badge_class = 'bg-secondary';
                                                break;
                                                case 'cancelled':
                                                $badge_class = 'bg-danger';
                                                break;
                                                case 'active':
                                                $badge_class = 'bg-success';
                                                break;
                                                case 'expired':
                                                $badge_class = 'bg-secondary';
                                                break;
                                                case 'completed':
                                                $badge_class = 'bg-success';
                                                break;
                                                default:
                                                $badge_class = 'bg-secondary';
                                                }
                                                @endphp
                                                <span class="badge {{ $badge_class }} fs-6">{{ ucfirst($status) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group list-group-flush pl-3 pr-3">
                                            <li class="list-group-item d-flex flex-column">
                                                <b>Additional services:</b>
                                                @foreach ($booking_data->additional_services as $key => $service)
                                                {{ $service->name }}@if (!$loop->last)
                                                ,
                                                @endif
                                                @endforeach
                                            </li>
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
                    <div class="col-md-4">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="card-title"><b>Booking Controls</b></h4>
                                <div class="mb-3">
                                    <br /><br />
                                    <label for="statusSelect" class="form-label float-right">Change Status</label>
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
                                <div class="mb-3">
                                    <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.booking.edit' : 'receptionist.booking.edit', $booking_data->id) }}" class="btn btn-warning w-100">Edit Reservation</a>
                                </div>
                                <div class="mb-3">
                                    <form action="{{ route(Auth::user()->hasRole('admin') ? 'admin.booking.delete' : 'receptionist.booking.delete', $booking_data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger w-100" type="submit">Delete Reservation</button>
                                    </form>
                                </div>
                                @isset($booking_data->guests[0]->first_name)
                                <div class="mb-3">
                                    <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.guests.create' : 'receptionist.guests.create') }}" class="btn btn-secondary w-100">Relate guests</a>
                                </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                    @isset($booking_data->guests[0]->first_name)
                    <div class="col-md-8 mt-2">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="card-title pl-4"><b>Guests</b></h4>
                                <table class="table">
                                    <tr>
                                        <td class="text-center"><b>
                                                <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.guests.show' : 'receptionist.guests.show', $booking_data->guests[0]->id) }}">
                                                    {{ $booking_data->guests[0]->first_name }}
                                                    {{ $booking_data->guests[0]->last_name }}</a></b></td>
                                        @if (count($booking_data->guests) > 1)
                                        <td class="text-center">
                                            <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.guests.show' : 'receptionist.guests.show', $booking_data->guests[1]->id) }}">
                                                {{ $booking_data->guests[1]->first_name }}
                                                {{ $booking_data->guests[1]->last_name }}</a>
                                        </td>
                                        @endif
                                    </tr>
                                    @if (count($booking_data->guests) > 2)
                                    @foreach ($booking_data->guests as $index => $guest)
                                    @if ($index >= 2)
                                    <tr>
                                        <td></td>
                                        <td class="text-center">
                                            <a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.guests.show' : 'receptionist.guests.show', $guest->id) }}">
                                                {{ $guest->first_name }} {{ $guest->last_name }}
                                            </a>
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
@endsection
@section('custom-scripts')
@vite(['resources/js/booking/show.js'])
@endsection