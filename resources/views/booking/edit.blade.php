@extends('layouts.header')
@section('title', 'Edit booking')
@section('booking_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/bookings-style.css'])
@endsection
@section('navbar_header_button')
<span id="header_booking_edit">Edit booking</span>
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
                    <div class="col-md-6">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="card-title pl-4"><b>Booking information</b></h4><br /><br />
                                <form action="{{ route(auth()->user()->hasRole('admin') ? 'admin.booking.update' : (auth()->user()->hasRole('receptionist') ? 'receptionist.booking.update' : '#'), $booking_data->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="booking_id" value="{{ $booking_data->id }}">
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">Room number:</th>
                                                        <td class="text-left">{{ $booking_data->rooms->room_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Room type:</th>
                                                        <td class="text-left">{{ strtoupper($booking_data->rooms->type) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="adultsCount" class="form-label">Adults:</label>
                                            <input type="number" class="form-control text-center @error('adultsCount') is-invalid @enderror" min="1" max="10" id="adultsCount" name="adultsCount" value="{{ $booking_data->adults_count }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="childrenCount" class="form-label">Children:</label>
                                            <input type="number" class="form-control text-center @error('childrenCount') is-invalid @enderror" min="0" max="10" id="childrenCount" name="childrenCount" value="{{ $booking_data->children_count }}" required>
                                        </div>
                                    </div>
                                    @php
                                    $date_check_in = date('Y-m-d', strtotime($booking_data->check_in_date));
                                    $date_check_out = date('Y-m-d', strtotime($booking_data->check_out_date));
                                    @endphp
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="checkInDate" class="form-label">Check-in Date:</label>
                                            <input type="date" class="form-control text-center @error('checkInDate') is-invalid @enderror" id="checkInDate" name="checkInDate" value="{{ $date_check_in }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="checkOutDate" class="form-label">Check-out Date</label>
                                            <input type="date" class="form-control text-center @error('checkOutDate') is-invalid @enderror" id="checkOutDate" name="checkOutDate" value="{{ $date_check_out }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="paymentType" class="form-label">Payment type:</label>
                                            <select class="form-select text-center @error('paymentType') is-invalid @enderror" id="paymentType" name="paymentType" required>
                                                <option value="credit_card" {{ $booking_data->payment_type == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                                <option value="cash" {{ $booking_data->payment_type == 'cash' ? 'selected' : '' }}>Cash</option>
                                                <option value="discount" {{ $booking_data->payment_type == 'discount' ? 'selected' : '' }}>Discount</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="hidden" id="price_per_night" value="{{ $booking_data->rooms->price }}" />
                                            <label for="totalCost" class="form-label">Total cost:</label>
                                            <input type="text" class="form-control text-center" id="totalCost" name="totalCost" value="{{ $booking_data->total_cost }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <textarea class="form-control @error('note') is-invalid @enderror" name="note" id="note">{{ $booking_data->note }}</textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Status:</label>
                                            <select class="form-select text-center @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="reserved" {{ $booking_data->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                                <option value="cancelled" {{ $booking_data->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                <option value="active" {{ $booking_data->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="expired" {{ $booking_data->status == 'expired' ? 'selected' : '' }}>Expired</option>
                                                <option value="completed" {{ $booking_data->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success w-100">Save changes</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card no-shadow" id="additional-service-card-header">
                            <div class="card-body">
                                <h4 class="card-title pl-4"><b>Additional services</b></h4>
                                <br /><br />
                                <div class="row">
                                    @foreach ($available_services->chunk(2) as $chunk)
                                    <div class="row">
                                        @foreach ($chunk as $service)
                                        @php
                                        $checked = $booking_data->additional_services->contains('name', $service->name);
                                        @endphp
                                        <div class="col-md-6 pl-4 pr-4">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input additionalServices" type="checkbox" data-price="{{ $service->price }}" value="{{ $service->id }}" id="service{{ $service->id }}" name="additionalServices[]" @if ($checked) checked @endif>
                                                <label class="form-check-label" for="service{{ $service->id }}">
                                                    {{ strtoupper($service->name) }} [ + {{ strtoupper($service->price) }}]
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="card no-shadow" id="guest-card-header">
                            <div class="card-body">
                                <h4 class="card-title mb-4 pl-4"><b>Guests</b></h4>
                                <br /><br />
                                <div class="row mb-3 ml-2 mr-2">
                                    <div class="col-sm-12">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Full name:</th>
                                                    <td class="text-left">
                                                        <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.guests.show' : (auth()->user()->hasRole('receptionist') ? 'receptionist.guests.show' : '#'), $booking_data->guests[0]->id) }}">
                                                            {{ $booking_data->guests[0]->first_name }} {{ $booking_data->guests[0]->last_name }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Contact phone number:</th>
                                                    <td class="text-left">{{ $booking_data->guests[0]->phone_number }}</td>
                                                </tr>
                                                <tr>
                                                    <form action="{{ route(auth()->user()->hasRole('admin') ? 'admin.guests.relation.submit' : (auth()->user()->hasRole('receptionist') ? 'receptionist.guests.relation.submit' : '#')) }}" method="POST">
                                                        @csrf
                                                        <td class="text-left">
                                                            <input type="hidden" name="search_guest_url" id="search_guest_url" value="{{ route(auth()->user()->hasRole('admin') ? 'admin.guests.search.relation' : (auth()->user()->hasRole('receptionist') ? 'receptionist.guests.search.relation' : '#')) }}" />
                                                            <input type="hidden" name="related_guest_id" id="related_guest_id" />
                                                            <input type="hidden" name="booking_id" id="booking_id" value="{{ $booking_data->id }}" />
                                                            <input type="text" class="form-control search-input text-center @error('guestName') is-invalid @enderror" name="guestName" id="relate-guest-name" placeholder="Relate guest: Guest name">
                                                            <div class="search-results"></div>
                                                        </td>
                                                        <td class="text-right">
                                                            <button type="submit" class="btn btn-outline-success btn-sm add-btn w-100">
                                                                <i class="bi bi-person-plus-fill"></i>
                                                            </button>
                                                        </td>
                                                    </form>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @if (count($booking_data->guests) > 1)
                                        <h5 class="card-title mt-2">Related</h5>
                                        <table class="table">
                                            <tbody>
                                                @foreach ($booking_data->guests as $index => $guest)
                                                <tr>
                                                    @if ($index >= 1)
                                                    <td>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="text-center">
                                                                <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.guests.show' : (auth()->user()->hasRole('receptionist') ? 'receptionist.guests.show' : '#'), $guest->id) }}">
                                                                    {{ $guest->first_name }} {{ $guest->last_name }}
                                                                </a>
                                                            </div>
                                                            <div>
                                                    </td>
                                                    <td class="text-right">
                                                        <form action="{{ route(auth()->user()->hasRole('admin') ? 'admin.guests.relation.delete' : (auth()->user()->hasRole('receptionist') ? 'receptionist.guests.relation.delete' : '#')) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="guest_id" id="guest_id" value="{{ $guest->id }}" />
                                                            <input type="hidden" name="booking_id" id="booking_id" value="{{ $booking_data->id }}" />
                                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                                <i class="bi bi-dash-circle-fill"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card no-shadow" id="available-dates-card-header">
                            <div class="card-body">
                                <h4 class="card-title mb-4 pl-4"><b>Available dates</b></h4>
                                <br /><br />
                                <div class="row mb-3 ml-2 mr-2">
                                    <div class="col-sm-12">
                                        <table class="table">
                                            <tbody>
                                                @isset($free_dates)
                                                @foreach($free_dates as $free)
                                                <tr>
                                                    <td class="text-left">
                                                        <b>
                                                            {{ $free }}
                                                        </b>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endisset
                                                <tr>
                                                    <td class="text-left">
                                                        <b>{{ \Carbon\Carbon::parse($last_free_date)->format('d.m.Y') }}</b> and later
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
@section('custom-scripts')
@vite(['resources/js/guests/search.js'])
@vite(['resources/js/booking/calculate_price.js'])
@endsection