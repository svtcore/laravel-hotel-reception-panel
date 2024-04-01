@extends('layouts.header')
@section('booking_navbar_state', 'active')
@section('additional_style')
    @vite(['resources/css/bookings-style.css'])
@endsection
@section('content')
    <div class="container-fluid mt-3">
        <div class="content-container">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
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
                                            <td>{{ \Carbon\Carbon::parse($booking_data->check_in_date)->format('d-m-Y') }}
                                            </td>
                                            <th>Check-out Date</th>
                                            <td>{{ \Carbon\Carbon::parse($booking_data->check_out_date)->format('d-m-Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Contact Number</th>
                                            <td colspan="3">{{ $booking_data->guests[0]->phone_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Additional Services</th>
                                            <td colspan="3">
                                                @foreach ($booking_data->additional_services as $key => $service)
                                                    {{ $service->name }}@if (!$loop->last)
                                                        ,
                                                    @endif
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
                                            <td>{{ ucfirst(str_replace('_', ' ', $booking_data->payment_type)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Note</th>
                                        </tr>
                                        <tr>
                                            <td colspan="4">{{ $booking_data->note }}</td>
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
                                    <div class="mb-3">
                                        <label for="statusSelect" class="form-label float-right">Change Status</label>
                                        <form id="statusForm" name="statusForm"
                                            action="{{ route('admin.booking.status', $booking_data->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select class="form-select" id="statusSelect" name="status">
                                                <option value="reserved"
                                                    {{ $booking_data->status === 'reserved' ? 'selected' : '' }}>Reserved
                                                </option>
                                                <option value="canceled"
                                                    {{ $booking_data->status === 'canceled' ? 'selected' : '' }}>Canceled
                                                </option>
                                                <option value="active"
                                                    {{ $booking_data->status === 'active' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="expired"
                                                    {{ $booking_data->status === 'expired' ? 'selected' : '' }}>Expired
                                                </option>
                                                <option value="completed"
                                                    {{ $booking_data->status === 'completed' ? 'selected' : '' }}>Completed
                                                </option>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="mb-3">
                                        <a href="{{ route('admin.booking.edit', $booking_data->id) }}"
                                            class="btn btn-primary w-100">Edit Reservation</a>
                                    </div>
                                    <div class="mb-3">
                                        <form action="{{ route('admin.booking.delete', $booking_data->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger w-100" type="submit">Delete Reservation</button>
                                        </form>
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
                                                            {{ $guest->last_name }}</td>
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
    @vite(['resources/js/booking/show.js'])
@endsection
@endsection
