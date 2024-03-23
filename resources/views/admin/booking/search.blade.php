@extends('layouts.header')
@section('booking_navbar_state', 'active')
@section('additional_style')
    @vite(['resources/css/bookings-style.css'])
@endsection
@section('content')
    <!-- Main content -->
    <div class="container-fluid mt-3">
        <div class="content-container">
            <!-- Content Header (Page header) -->
            <div class="content-header">
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
                                <div class="col-md-2 mb-2 date-block">
                                    <label for="startDate">Start date</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate" disabled
                                        required>
                                </div>
                                <div class="col-md-2 mb-2 date-block">
                                    <label for="endDate">End date</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate" disabled
                                        required>
                                </div>
                                <div class="col-md-3 pt-2">
                                    <label for="guestName"></label>
                                    <input type="text" class="form-control" id="guestName" name="guestName"
                                        placeholder="Full name" required>
                                </div>
                                <div class="col-md-2 pt-2">
                                    <label for="phoneNumber"></label>
                                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber"
                                        placeholder="Phone number" disabled required>
                                </div>
                                <div class="col-md-3 pt-2">
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
                                    <th>Persons</th>
                                    <th>Phone number</th>
                                    <th>Price</th>
                                    <th>Check-In</th>
                                    <th>Check-Out</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $booking)
                                    <tr class="text-center">
                                        <td class="text-center"><a href="#">{{ $booking->rooms->door_number }}</a>
                                        </td>
                                        <td class="text-center">{{ $booking->guests[0]->first_name }}
                                            {{ $booking->guests[0]->last_name }} {{ $booking->guests[0]->middlename }}</td>
                                        <td class="text-center">{{ ucfirst($booking->rooms->type) }}</td>
                                        <td class="text-center">{{ $booking->adult_amount }} @if ($booking->children_amount > 0)
                                                + {{ $booking->children_amount }}
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $booking->guests[0]->phone_number }}</td>
                                        <td class="text-center">{{ $booking->total_cost }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($booking->check_in_date)->format('Y-m-d') }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($booking->check_out_date)->format('Y-m-d') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <a href="{{ route('admin.booking.show', $booking->id) }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-address-card"></i> Details
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

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- /.content -->
@section('custom-scripts')
    @vite(['resources/js/booking/search.js'])
@endsection
@endsection
