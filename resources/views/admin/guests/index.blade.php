@extends('layouts.header')
@section('booking_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/bookings-style.css'])
@endsection
@section('navbar_header_button')
    <a href="#" class="add-new-button">Add Guest</a>
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="content-container">
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
                    <h4><b>Search form</b></h4>

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
                                <input type="date" class="form-control" id="startDate" name="startDate" disabled value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                            </div>
                            <div class="col-md-2 mb-2 mt-2 date-block">
                                <label for="endDate">End date</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" disabled value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                            </div>
                            <div class="col-md-3 pt-2">
                                <label for="guestName">Guest name</label>
                                <input type="text" class="form-control" id="guestName" name="guestName" placeholder="Full name" required minlength="2" maxlength="255">
                                <div class="invalid-feedback">
                                    Please provide a valid guest name.
                                </div>
                            </div>
                            <div class="col-md-2 pt-2">
                                <label for="phoneNumber">Phone number</label>
                                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone number" disabled required minlength="10" maxlength="15">
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
                    <h4><b>Events for today</b></h4>
                </div>
                <div>

                </div>
            </div>
        </div>
    </div>
</div>
@section('custom-scripts')

@endsection
@endsection
