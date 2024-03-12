@extends('layouts.header')
@section('dashboard_navbar_state', 'active')
@section('additional_style')
    @vite(['resources/css/bookings-style.css'])
@endsection
@section('content')
    <div class="container-fluid mt-3">
        <div class="content-container">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Reservation details -->
                    <div class="row">
                        <!-- Reservation -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Reservation Details</h5>
                                    <table class="table">
                                        <tr>
                                            <th>Room Number</th>
                                            <td>{{ $booking_data->rooms->door_number }}</td>
                                            <th>Room type</th>
                                            <td>{{ ucfirst($booking_data->rooms->type) }} </td>
                                        </tr>
                                        <tr>
                                            <th>Adults</th>
                                            <td>{{ $booking_data->adult_amount }}</td>
                                            <th>Children</th>
                                            <td>{{ $booking_data->children_amount }}</td>
                                        </tr>
                                        <tr>
                                            <th>Check-in Date</th>
                                            <td>{{ \Carbon\Carbon::parse($booking_data->check_in_date)->format('Y-m-d') }}
                                            </td>
                                            <th>Check-out Date</th>
                                            <td>{{ \Carbon\Carbon::parse($booking_data->check_out_date)->format('Y-m-d') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Contact Number</th>
                                            <td colspan="3">{{ $booking_data->guests[0]->phone_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Additional Services</th>
                                            <td colspan="3">
                                                @foreach ($booking_data->additional_services as $service)
                                                    {{ $service->name }},
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td collspan="3">{{ ucfirst($booking_data->status) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total cost</th>
                                            <td>{{ $booking_data->total_cost }}</td>
                                            <th>Payment type</th>
                                            <td>{{ $booking_data->payment_type }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Booking controls -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Booking Controls</h5>
                                    <!-- Кнопки управления бронированием -->
                                    <div class="mb-3">
                                        <label for="statusSelect" class="form-label float-right">Change Status</label>
                                        <select class="form-select" id="statusSelect">
                                            <option value="confirmed">Confirmed</option>
                                            <option value="pending">Pending</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100">Edit Reservation</button>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-danger w-100">Delete Reservation</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Guests -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Guests</h5>
                                    <table class="table">
                                        <tr>
                                            <td class="text-center"><b>{{ $booking_data->guests[0]->first_name }} {{ $booking_data->guests[0]->last_name }}</b></td>
                                                @if (count($booking_data->guests) > 1)
                                                    <td class="text-center">
                                                        {{ $booking_data->guests[1]->first_name }} {{ $booking_data->guests[1]->last_name }}
                                                    </td>
                                                @endif
                                        </tr>
                                        @if (count($booking_data->guests) > 2)
                                            @foreach ($booking_data->guests as $index => $guest)
                                                @if ($index >= 2)
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center">{{ $guest->first_name }} {{ $guest->last_name }}</td>
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
            <!-- /.content -->
        </div>
        <!-- /.content-container -->
    </div>
    <!-- /.container-fluid -->
@section('custom-scripts')
    @vite(['resources/js/booking/search.js'])
@endsection
@endsection
