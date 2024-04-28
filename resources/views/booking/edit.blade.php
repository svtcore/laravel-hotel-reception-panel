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
                <div class="row">
                    <div class="col-md-6">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="card-title pl-4"><b>Reservation Details</b></h4><br /><br />
                                @role('admin')
                                <form action="{{ route('admin.booking.update', $booking_data->id) }}" method="POST">
                                    @endrole
                                    @role('receptionist')
                                    <form action="{{ route('receptionist.booking.update', $booking_data->id) }}" method="POST">
                                        @endrole
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="booking_id" value="{{ $booking_data->id }}">
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-12">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Room number</th>
                                                            <td class="text-left">{{ $booking_data->rooms->room_number }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Room type</th>
                                                            <td class="text-left">{{ strtoupper($booking_data->rooms->type) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-6">
                                                <label for="adultsCount" class="form-label">Adults</label>
                                                <input type="number" class="form-control" id="adultsCount" name="adultsCount" value="{{ $booking_data->adults_count }}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="childrenCount" class="form-label">Children</label>
                                                <input type="number" class="form-control" id="childrenCount" name="childrenCount" value="{{ $booking_data->children_count }}">
                                            </div>
                                        </div>
                                        <?php
                                        $date_check_in = date('Y-m-d', strtotime($booking_data->check_in_date));
                                        $date_check_out = date('Y-m-d', strtotime($booking_data->check_out_date));
                                        ?>
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-6">
                                                <label for="checkInDate" class="form-label">Check-in Date</label>
                                                <input type="date" class="form-control" id="checkInDate" name="checkInDate" value="{{ $date_check_in }}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="checkOutDate" class="form-label">Check-out Date</label>
                                                <input type="date" class="form-control" id="checkOutDate" name="checkOutDate" value="{{ $date_check_out }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-6">
                                                <label for="paymentType" class="form-label">Payment type</label>
                                                <select class="form-select" id="paymentType" name="paymentType">
                                                    <option value="credit_card" {{ $booking_data->payment_type == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                                    <option value="cash" {{ $booking_data->payment_type == 'cash' ? 'selected' : '' }}>Cash</option>
                                                    <option value="discount" {{ $booking_data->payment_type == 'discount' ? 'selected' : '' }}>Discount</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="totalCost" class="form-label">Total cost</label>
                                                <input type="text" class="form-control" id="totalCost" name="totalCost" value="{{ $booking_data->total_cost }}" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-12">
                                                <textarea class="form-control" name="note">{{ $booking_data->note }}</textarea>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="status" name="status">
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
                                            @php
                                            $checked = false;
                                            foreach ($booking_data->additional_services as $additional_service) {
                                            if ($additional_service->name === $service->name) {
                                            $checked = true;
                                            break;
                                            }
                                            }
                                            @endphp
                                            <input class="form-check-input" type="checkbox" value="{{ $service->id }}" id="service{{ $service->id }}" name="additionalServices[]" @if ($checked) checked @endif>
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
                        </form>
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="card-title mb-4 pl-4"><b>Guests</b></h4>
                                <br /><br />
                                <div class="row mb-3 ml-2 mr-2">
                                    <div class="col-sm-12">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Full name</th>
                                                    @role('admin')
                                                    <td class="text-left"><a href="{{ route('admin.guests.show', $booking_data->guests[0]->id) }}">{{ $booking_data->guests[0]->first_name }} {{ $booking_data->guests[0]->last_name }}</a></td>
                                                    @endrole
                                                    @role('receptionist')
                                                    <td class="text-left"><a href="{{ route('receptionist.guests.show', $booking_data->guests[0]->id) }}">{{ $booking_data->guests[0]->first_name }} {{ $booking_data->guests[0]->last_name }}</a></td>
                                                    @endrole
                                                </tr>
                                                <tr>
                                                    <th scope="row">Contact phone number</th>
                                                    <td class="text-left">{{ $booking_data->guests[0]->phone_number }}</td>
                                                </tr>
                                                <tr>
                                                        @role('admin')
                                                        <form action="{{ route('admin.guests.relation.submit') }}" method="POST">
                                                        @endrole
                                                        @role('receptionist')
                                                        <form action="{{ route('receptionist.guests.relation.submit') }}" method="POST">
                                                            @endrole
                                                            @csrf
                                                            <td class="text-left">
                                                                <div class="input-group">
                                                                    @role('admin')
                                                                    <input type="hidden" name="search_guest_url" id="search_guest_url" value="{{ route('admin.guests.search.relation') }}" />
                                                                    @endrole
                                                                    @role('receptionist')
                                                                    <input type="hidden" name="search_guest_url" id="search_guest_url" value="{{ route('receptionist.guests.search.relation') }}" />
                                                                    @endrole
                                                                    <input type="hidden" name="related_guest_id" id="related_guest_id" />
                                                                    <input type="hidden" name="booking_id" id="booking_id" value="{{ $booking_data->id }}" />
                                                                    <input type="text" class="form-control search-input" name="guestName" style="height: 33px;" placeholder="Relate guest: Guest name">
                                                                </div>
                                                                <div class="search-results"></div>
                                                            </td>
                                                            <td class="text-right">
                                                                <button type="submit" class="btn btn-outline-success btn-sm add-btn" type="button"><i class="fa-solid fa-plus"></i></button>
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
                                                                @role('admin')
                                                                <a href="{{ route('admin.guests.show', $guest->id) }}">
                                                                    @endrole
                                                                    @role('receptionist')
                                                                    <a href="{{ route('receptionist.guests.show', $guest->id) }}">
                                                                        @endrole
                                                                        {{ $guest->first_name }} {{ $guest->last_name }}
                                                                    </a>
                                                            </div>
                                                            <div>
                                                    </td>
                                                    <td class="text-right">
                                                        @role('admin')
                                                        <form action="{{ route('admin.guests.relation.delete') }}" method="POST">
                                                            @endrole
                                                            @role('receptionist')
                                                            <form action="{{ route('receptionist.guests.relation.delete') }}" method="POST">
                                                                @endrole
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="guest_id" id="guest_id" value="{{ $guest->id }}" />
                                                                <input type="hidden" name="booking_id" id="booking_id" value="{{ $booking_data->id }}" />
                                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                    <i class="fa-solid fa-ban"></i>
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
            </div>
        </section>
    </div>
</div>
@section('custom-scripts')
@vite(['resources/js/guests/search.js'])
@endsection
@endsection