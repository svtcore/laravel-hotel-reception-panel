@extends('layouts.header')
@section('booking_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/bookings-style.css'])
@endsection
@section('navbar_header_button')
<span class="header-navbar">Booking</span>
@endsection
@section('content')
<!-- Main content -->
<div class="container-fluid mt-5">
    <div class="content-container">
        <!-- Content Header (Page header) -->
        <div class="content-header">
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
                <div class="content-container text-center">
                    <h4>Search form</h4>

                    <form id="searchForm" method="POST" action="{{ route('admin.booking.search') }}">
                        @csrf
                        <div class="row mt-5">
                            <div class="col-md-4">
                                <label class="toggle">
                                    <input class="toggle-checkbox" id="switch-by-date" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label">By date</span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="toggle" checked>
                                    <input class="toggle-checkbox" id="switch-by-name" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label">By guest name</span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="toggle">
                                    <input class="toggle-checkbox" id="switch-by-phone" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label">By phone</span>
                                </label>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-2 mt-2 date-block">
                                <label for="startDate">Start date</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" disabled
                                    @if (isset($inputData['startDate'])) value="{{ $inputData['startDate'] }}" @else value="{{ \Carbon\Carbon::now()->toDateString() }}" @endif
                                    required>
                            </div>
                            <div class="col-md-2 mb-2 mt-2 date-block">
                                <label for="endDate">End date</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" disabled
                                    @if (isset($inputData['endDate'])) value="{{ $inputData['endDate'] }}" @else value="{{ \Carbon\Carbon::now()->toDateString() }}" @endif
                                    required>
                            </div>
                            <div class="col-md-3 pt-2">
                                <label for="guestName">Guest name</label>
                                <input type="text" class="form-control" id="guestName" name="guestName"
                                    @if (isset($inputData['guestName'])) value="{{ $inputData['guestName'] }}" @endif
                                    placeholder="Full name" required minlength="2" maxlength="255">
                                <div class="invalid-feedback">
                                    Please provide a valid guest name.
                                </div>
                            </div>
                            <div class="col-md-2 pt-2">
                                <label for="phoneNumber">Phone number</label>
                                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber"
                                    @if (isset($inputData['phoneNumber'])) value="{{ $inputData['phoneNumber'] }}" @endif
                                    placeholder="Phone number" disabled required minlength="10" maxlength="15">
                                <div class="invalid-feedback">
                                    Please provide a valid phone number.
                                </div>
                            </div>
                            <div class="col-md-3 pt-2 mt-2">
                                <label for="phoneNumber"></label>
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <h4><b>Search results</b></h4>
                </div>
                <div id="chat-container">
                    <table id="result-table" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">Room №</th>
                                <th>Guest name</th>
                                <th>Room type</th>
                                <th>Phone number</th>
                                <th>Price</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result as $booking)
                            <tr class="text-center">
                                <td class="text-center"><a href="{{ route('admin.rooms.show', $booking->rooms->id) }}">{{ $booking->rooms->room_number }}</a>
                                </td>
                                <td class="text-center">
                                    @isset($booking->guests[0]->first_name)
                                        {{ $booking->guests[0]->first_name }} {{ $booking->guests[0]->last_name }}
                                    @endisset
                                </td>
                                <td class="text-center">{{ ucfirst($booking->rooms->type) }}</td>
                                <td class="text-center">@isset ($booking->guests[0]->phone_number) {{ $booking->guests[0]->phone_number }} @endisset</td>
                                <td class="text-center">{{ $booking->total_cost }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    @if ($booking->status == 'active' || $booking->status == 'completed')
                                    <span class="badge badge-success badge-big">{{ $booking->status }}</span>
                                    @elseif ($booking->status == 'cancelled')
                                    <span class="badge badge-danger badge-big">{{ $booking->status }}</span>
                                    @else
                                    <span class="badge badge-secondary badge-big">{{ $booking->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('admin.booking.show', $booking->id) }}"
                                            class="btn btn-secondary pt-0 pb-0 pr-4 pl-4">Details
                                        </a>
                                    </div>
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
@section('custom-scripts')
@vite(['resources/js/booking/search.js'])
@endsection
@endsection
