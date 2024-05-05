@extends('layouts.header')
@section('guests_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/guests-style.css'])
@endsection
@section('navbar_header_button')
@role('admin')
<a href="{{ route('admin.guests.create') }}" style="width:400px;" class="add-new-button">Add Guest</a>
@endrole
@role('receptionist')
<a href="{{ route('receptionist.guests.create') }}" style="width:400px;" class="add-new-button">Add Guest</a>
@endrole
@endsection
@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <div class="content-header">
            <div class="container-fluid mt-4">
                <!-- Display success message if any -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <!-- Display error messages if any -->
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
                    <h4 class="font-weight-bold">Search form</h4>
                    <!-- Form for searching guests by admin -->
                    @role('admin')
                    <form id="searchForm" method="POST" action="{{ route('admin.guests.search') }}">
                        @endrole
                        <!-- Form for searching guests by receptionist -->
                        @role('receptionist')
                        <form id="searchForm" method="POST" action="{{ route('receptionist.guests.search') }}">
                            @endrole
                            @csrf
                            <div class="row mt-5">
                                <div class="col-md-4">
                                    <label class="toggle" checked>
                                        <input class="toggle-checkbox" id="switch-by-name" type="checkbox">
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">By guest name</span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="toggle">
                                        <input class="toggle-checkbox" id="switch-by-phone" type="checkbox">
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">By phone</span>
                                    </label>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 pt-2">
                                    <label for="guestName">Guest name</label>
                                    <input type="text" class="form-control" id="guestName" name="guestName" placeholder="Full name" required minlength="2" maxlength="255">
                                    <div class="invalid-feedback">
                                        Please provide a valid guest name.
                                    </div>
                                </div>
                                <div class="col-md-3 pt-2">
                                    <label for="phoneNumber">Phone number</label>
                                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone number" disabled required minlength="10" maxlength="15">
                                    <div class="invalid-feedback">
                                        Please provide a valid phone number.
                                    </div>
                                </div>
                                <div class="col-md-5 pt-2 mt-2">
                                    <label for="phoneNumber"></label>
                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                </div>
                            </div>
                        </form>
                </div>
                <div class="mt-4 text-center">
                    <h4><b>Last 50 guests</b></h4>
                </div>
                <div>
                    <table id="guests-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Full name</th>
                                <th class="text-center">Gender</th>
                                <th class="text-center">DOB</th>
                                <th class="text-center">Phone number</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through guests data and display them in table -->
                            @foreach ($guests as $guest)
                            <tr>
                                <td class="text-center">{{ $guest->first_name }} {{ $guest->last_name }}</td>
                                <td class="text-center">
                                    <!-- Display gender -->
                                    @if ($guest->gender == "M") Male
                                    @elseif ($guest->gender == "F") Female
                                    @else Other
                                    @endif
                                </td>
                                <!-- Display date of birth -->
                                <td class="text-center">{{ \Carbon\Carbon::parse($guest->dob)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ $guest->phone_number }}</td>
                                <td class="text-center">
                                    <!-- Action buttons for admin and receptionist -->
                                    @role('admin')
                                    <form action="{{ route('admin.guests.delete', $guest->id) }}" method="POST">
                                        @endrole
                                        @role('receptionist')
                                        <form action="{{ route('receptionist.guests.delete', $guest->id) }}" method="POST">
                                            @endrole
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <!-- Button for viewing guest details -->
                                                @role('admin')
                                                <a href="{{ route('admin.guests.show', $guest->id) }}" class="btn btn-primary">Details</a>
                                                <!-- Button for editing guest details -->
                                                <a href="{{ route('admin.guests.edit', $guest->id) }}" type="button" class="btn btn-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                @endrole
                                                <!-- Button for viewing guest details by receptionist -->
                                                @role('receptionist')
                                                <a href="{{ route('receptionist.guests.show', $guest->id) }}" class="btn btn-secondary">Details</a>
                                                <!-- Button for editing guest details by receptionist -->
                                                <a href="{{ route('receptionist.guests.edit', $guest->id) }}" type="button" class="btn btn-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                @endrole
                                                @csrf
                                                @method('DELETE')
                                                <!-- Button for deleting guest -->
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </form>
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
@vite(['resources/js/guests/index.js'])
@endsection
@endsection