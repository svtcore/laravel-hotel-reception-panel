@extends('layouts.header')
@section('title', 'Guests')
@section('guests_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/guests-style.css'])
@endsection
@section('navbar_header_button')
<a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.guests.create' : (auth()->user()->hasRole('receptionist') ? 'receptionist.guests.create' : '#')) }}" class="add-new-button">Add guest</a>
@endsection
@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <div class="content-header">
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
                <div class="content-container text-center">
                    <h4><b>Search form</b></h4>
                    <form id="searchForm" method="POST" action="{{ route(auth()->user()->hasRole('admin') ? 'admin.guests.search' : (auth()->user()->hasRole('receptionist') ? 'receptionist.guests.search' : '#')) }}">
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
                        <div class="row">
                            <div class="col-md-4 pt-2">
                                <label for="guestName"></label>
                                <input type="text" class="form-control text-center @error('guestName') is-invalid @enderror" id="guestName" name="guestName" placeholder="Full name" required minlength="2" maxlength="255">
                                <div class="invalid-feedback">
                                    Please provide a valid guest name.
                                </div>
                            </div>
                            <div class="col-md-3 pt-2">
                                <label for="phoneNumber"></label>
                                <input type="text" class="form-control text-center @error('phoneNumber') is-invalid @enderror" id="phoneNumber" name="phoneNumber" placeholder="Phone number" disabled required minlength="10" maxlength="15">
                                <div class="invalid-feedback">
                                    Please provide a valid phone number.
                                </div>
                            </div>
                            <div class="col-md-5 pt-2">
                                <label for="searchButton"></label>
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
                                <th class="text-center">Phone</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guests as $guest)
                            <tr>
                                <td class="text-center">{{ $guest->first_name }} {{ $guest->last_name }}</td>
                                <td class="text-center">
                                    @if ($guest->gender == "M") Male
                                    @elseif ($guest->gender == "F") Female
                                    @else Other
                                    @endif
                                </td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($guest->dob)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ $guest->phone_number }}</td>
                                <td class="text-center">
                                    @role('admin')
                                        <form action="{{ route(admin.guests.delete, $guest->id) }}" method="POST">
                                    @endrole
                                        <div class="btn-group w-100" role="group" aria-label="First group">
                                            <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.guests.show' : (auth()->user()->hasRole('receptionist') ? 'receptionist.guests.show' : '#'), $guest->id) }}" class="btn btn-secondary">Details</a>

                                            <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.guests.edit' : (auth()->user()->hasRole('receptionist') ? 'receptionist.guests.edit' : '#'), $guest->id) }}" type="button" class="btn btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            @role('admin')
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            @endrole
                                        </div>
                                    @role('admin')
                                        </form>
                                    @endrole
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
@endsection
@section('custom-scripts')
@vite(['resources/js/guests/index.js'])
@endsection