@extends('layouts.header')
@section('booking_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/bookings-style.css'])
@endsection
@section('navbar_header_button')
    <a href="#" class="add-new-button">New Reservation</a>
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="content-container">
        <section class="content">
            <div class="container-fluid mt-4">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush pl-3 pr-3">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Room Number
                                                <span class="badge bg-primary badge-big">{{ $booking_data->rooms->door_number }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Room type
                                                <span class="badge bg-primary badge-big">{{ ucfirst($booking_data->rooms->type) }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Adults
                                                <span class="badge bg-primary badge-big">{{ $booking_data->adults_count }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Children
                                                <span class="badge bg-primary badge-big">{{ $booking_data->children_count }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Check-in Date
                                                <span class="badge bg-primary badge-big">{{ \Carbon\Carbon::parse($booking_data->check_in_date)->format('d-m-Y') }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Check-out Date
                                                <span class="badge bg-primary badge-big">{{ \Carbon\Carbon::parse($booking_data->check_out_date)->format('d-m-Y') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush pl-2 pr-2">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Contact Number
                                                <span class="badge bg-primary badge-big">{{ $booking_data->guests[0]->phone_number }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Payment type
                                                <span class="badge bg-primary badge-big">{{ ucfirst(str_replace('_', ' ', $booking_data->payment_type)) }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Total cost
                                                <span class="badge bg-primary badge-big">{{ $booking_data->total_cost }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Status
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
                                    <label for="statusSelect" class="form-label float-right">Change Status</label>
                                    <form id="statusForm" name="statusForm" action="{{ route('admin.booking.status', $booking_data->id) }}" method="POST">
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
                                    <a href="{{ route('admin.booking.edit', $booking_data->id) }}" class="btn btn-primary w-100">Edit Reservation</a>
                                </div>
                                <div class="mb-3">
                                    <form action="{{ route('admin.booking.delete', $booking_data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger w-100" type="submit">Delete Reservation</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="card-title pl-4"><b>Guests</b></h4>
                                <table class="table">
                                    <tr>
                                        <td class="text-center"><b>{{ $booking_data->guests[0]->first_name }}
                                                {{ $booking_data->guests[0]->last_name }}</b></td>
                                        @if (count($booking_data->guests) > 1)
                                        <td class="text-center">
                                            {{ $booking_data->guests[1]->first_name }}
                                            {{ $booking_data->guests[1]->last_name }}
                                        </td>
                                        @endif
                                    </tr>
                                    @if (count($booking_data->guests) > 2)
                                    @foreach ($booking_data->guests as $index => $guest)
                                    @if ($index >= 2)
                                    <tr>
                                        <td></td>
                                        <td class="text-center">{{ $guest->first_name }}
                                            {{ $guest->last_name }}
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@section('custom-scripts')
@vite(['resources/js/booking/show.js'])
@endsection
@endsection
