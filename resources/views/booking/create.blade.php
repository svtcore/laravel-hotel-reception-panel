@extends('layouts.header')
@section('title', 'Add booking')
<!-- Navbar state -->
@section('booking_navbar_state', 'active')

<!-- Additional styles -->
@section('additional_style')
@vite(['resources/css/bookings-style.css'])
@endsection

<!-- Navbar header button -->
@section('navbar_header_button')
<span class="header-navbar">Adding new booking</span>
@endsection

<!-- Main content -->
@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <section class="content">
            <div class="container-fluid">

                <!-- Success message -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Error messages -->
                @if ($errors->any())
                <div class="custom-error-message">
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Admin and Receptionist forms -->
                @role('admin')
                    <form action="{{ route('admin.booking.store') }}" method="POST">
                @endrole
                @role('receptionist')
                    <form action="{{ route('receptionist.booking.store') }}" method="POST">
                @endrole
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card no-shadow">
                                    <div class="card-body">
                                        <h4 class="card-title pl-4"><b>Booking Information</b></h4>
                                        <br /><br />

                                        <!-- Room details -->
                                        @csrf
                                        <input type="hidden" id="room_id" name="room_id" value="{{ $room->id }}" />
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-12">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Room number:</th>
                                                            <td class="text-left">{{ $room->room_number }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Room type:</th>
                                                            <td class="text-left">{{ strtoupper($room->type) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Reservation form -->
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-6">
                                                <label for="adultsCount" class="form-label">Adults:</label>
                                                <input type="number" class="form-control text-center @error('adultsCount') is-invalid @enderror" id="adultsCount" name="adultsCount" value="1" min="1" max="{{ $room->adults_beds_count }}" value="{{ old('adultsCount') }}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="childrenCount" class="form-label">Children:</label>
                                                <input type="number" class="form-control text-center @error('childrenCount') is-invalid @enderror" id="childrenCount" name="childrenCount" value="0" min="0" max="{{ $room->children_beds_count }}" value="{{ old('childrenCount') }}">
                                            </div>
                                        </div>

                                        <!-- Dates and Payment -->
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-6">
                                                <label for="checkInDate" class="form-label">Check-in Date:</label>
                                                <input type="date" class="form-control text-center @error('checkInDate') is-invalid @enderror" id="checkInDate" name="checkInDate" value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="checkOutDate" class="form-label">Check-out Date:</label>
                                                <input type="date" class="form-control text-center @error('checkOutDate') is-invalid @enderror" id="checkOutDate" name="checkOutDate" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-6">
                                                <label for="paymentType" class="form-label">Payment type:</label>
                                                <select class="form-select text-center @error('paymentType') is-invalid @enderror" id="paymentType" name="paymentType">
                                                    <option value="credit_card" selected>Credit Card</option>
                                                    <option value="cash">Cash</option>
                                                    <option value="discount">Discount</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="hidden" id="price_per_night" value="{{ $room->price }}" />
                                                <label for="totalCost" class="form-label text-center">Total cost:</label>
                                                <input type="text" class="form-control text-center" id="totalCost" name="totalCost" disabled>
                                            </div>
                                        </div>

                                        <!-- Note and Status -->
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-12">
                                                <textarea class="form-control text-center @error('note') is-invalid @enderror" name="note" id="note">{{ old('note') }}</textarea>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="status" class="form-label">Status:</label>
                                                <select class="form-select text-center @error('status') is-invalid @enderror" id="status" name="status">
                                                    <option value="reserved" selected>Reserved</option>
                                                    <option value="cancelled">Cancelled</option>
                                                    <option value="active">Active</option>
                                                    <option value="expired">Expired</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Save Changes button -->
                                        <div class="row ml-2 mr-2">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-primary w-100">Confirm booking</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Services -->
                            <div class="col-md-6">
                                <div class="card no-shadow">
                                    <div class="card-body">
                                        <h4 class="card-title pl-4"><b>Additional services</b></h4>
                                        <br /><br />
                                        <div class="row">
                                            @php $count = 0 @endphp
                                            @foreach ($available_services as $service)
                                            @if ($count % 2 == 0)
                                            @if ($count != 0)
                                        </div>
                                        <div class="row">
                                            @endif
                                            @endif
                                            <div class="col-md-6 pl-4 pr-4">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input additionalServices" type="checkbox" data-price="{{ $service->price }}" value="{{ $service->id }}" id="service{{ $service->id }}" name="additionalServices[]">
                                                    <label class="form-check-label" for="service{{ $service->id }}">
                                                        {{ strtoupper($service->name) }} [ + {{ strtoupper($service->price) }}]
                                                    </label>
                                                </div>
                                            </div>
                                            @php $count++ @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Guest information -->
                                <div class="card no-shadow">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4 pl-4"><b>Guest (Main)</b></h4>
                                        <br /><br />
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-12">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-left">
                                                                <input type="text" name="firstName" id="firstName" placeholder="First name" maxlength="256" class="form-control text-center @error('firstName') is-invalid @enderror" required/>
                                                            </td>
                                                            <td class="text-left">
                                                                <input type="text" name="lastName" id="lastName" placeholder="Last name" maxlength="256" class="form-control text-center @error('lastName') is-invalid @enderror" required/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left" colspan="2">
                                                                <input type="number" name="phoneNumber" id="phoneNumber" placeholder="Contact phone number" maxlength="30" class="form-control text-center w-100 @error('phoneNumber') is-invalid @enderror" required/>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Available dates -->
                                <div class="card no-shadow">
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
                    </form>
        </section>
    </div>
</div>

<!-- Custom scripts -->
@section('custom-scripts')
@vite(['resources/js/booking/calculate_price.js'])
@endsection
@endsection