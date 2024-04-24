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
                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Reservation Details</b></h4><br /><br />
                                    @csrf
                                    <input type="hidden" id="room_id" name="room_id" value="{{ $room->id }}" />
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">Room number</th>
                                                        <td class="text-left">{{ $room->room_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Room type</th>
                                                        <td class="text-left">{{ strtoupper($room->type) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="adultsCount" class="form-label">Adults</label>
                                            <input type="number" class="form-control" id="adultsCount" name="adultsCount" value="1" min="1" max="{{ $room->adults_beds_count }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="childrenCount" class="form-label">Children</label>
                                            <input type="number" class="form-control" id="childrenCount" name="childrenCount" value="0" min="0" max="{{ $room->children_beds_count }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="checkInDate" class="form-label">Check-in Date</label>
                                            <input type="date" class="form-control" id="checkInDate" name="checkInDate">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="checkOutDate" class="form-label">Check-out Date</label>
                                            <input type="date" class="form-control" id="checkOutDate" name="checkOutDate">
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="paymentType" class="form-label">Payment type</label>
                                            <select class="form-select" id="paymentType" name="paymentType">
                                                <option value="credit_card">Credit Card</option>
                                                <option value="cash">Cash</option>
                                                <option value="discount">Discount</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="totalCost" class="form-label">Total cost</label>
                                            <input type="text" class="form-control" id="totalCost" name="totalCost" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="note"></textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="reserved">Reserved</option>
                                                <option value="cancelled">Cancelled</option>
                                                <option value="active">Active</option>
                                                <option value="expired">Expired</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Additional Services</b></h4>
                                    <br /><br />
                                    <div class="row">
                                        @php $count = 0 @endphp
                                        @foreach ($avaliable_services as $service)
                                        @if ($count % 2 == 0)
                                        @if ($count != 0)
                                    </div>
                                    <div class="row">
                                        @endif
                                        @endif
                                        <div class="col-md-6 pl-4 pr-4">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" value="{{ $service->id }}" id="service{{ $service->id }}" name="additionalServices[]">
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
                                                            <input type="text" name="firstName" id="firstName" placeholder="First name" class="form-control" />
                                                        </td>
                                                        <td class="text-left">
                                                            <input type="text" name="lastName" id="lastName" placeholder="Last name" class="form-control" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left" colspan="2">
                                                            <input type="text" name="phoneNumber" id="phoneNumber" placeholder="Contact phone number" class="form-control w-100" />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title mb-4 pl-4"><b>Avaliable dates</b></h4>
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
            </div>
        </section>
    </div>
</div>
@section('custom-scripts')

@endsection
@endsection