@extends('layouts.header')
@section('title', 'Add guest')
@section('guests_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/guests-style.css'])
@endsection
@section('content')
@section('navbar_header_button')
<span id="header_guests_add">Add guest</span>
@endsection
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

                <form id="addForm" action="{{ auth()->user()->hasRole('admin') ? route('admin.guests.store') : (auth()->user()->hasRole('receptionist') ? route('receptionist.guests.store') : '#') }}" method="POST">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Guest information</b></h4><br /><br />
                                    @csrf
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="firstName" class="form-label">First name:</label>
                                            <input type="text" class="form-control text-center @error('firstName') is-invalid @enderror" id="firstName" name="firstName" value="{{ old('firstName') }}" maxlength="255" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="lastName" class="form-label">Last name:</label>
                                            <input type="text" class="form-control text-center @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ old('lastName') }}" maxlength="255" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="gender" class="form-label">Gender:</label>
                                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                                <option value="N">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="dob" class="form-label">DOB:</label>
                                            <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob') }}" required>
                                        </div>
                                    </div>
                                    <div class="row ml-2 mr-2 mb-3">
                                        <div class="col-sm-12">
                                            <label for="phoneNumber" class="form-label">Phone number:</label>
                                            <input type="number" class="form-control text-center @error('phoneNumber') is-invalid @enderror" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber') }}" maxlength="20">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Document</b></h4><br /><br />
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <input type="hidden" id="documentCountry" value=""> <label for="countryCode" class="form-label">Country:</label>
                                            <select class="form-select @error('countryCode') is-invalid @enderror" id="countryCode" name="countryCode">
                                                <option value="">Select Country Code</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-4">
                                            <label for="documentSerial" class="form-label">Document serial:</label>
                                            <input type="text" class="form-control text-center @error('documentSerial') is-invalid @enderror" id="documentSerial" name="documentSerial" value="{{ old('documentSerial') }}" maxlength="255">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="documentNumber" class="form-label">Doc. number:</label>
                                            <input type="text" class="form-control text-center @error('documentNumber') is-invalid @enderror" id="documentNumber" name="documentNumber" value="{{ old('documentNumber') }}" maxlength="255">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="documentExpired" class="form-label">Document expired:</label>
                                            <input type="date" class="form-control text-center @error('documentExpired') is-invalid @enderror" id="documentExpired" name="documentExpired" value="{{ old('documentExpired') }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-8">
                                            <label for="documentIssuedBy" class="form-label">Document issued by:</label>
                                            <input type="text" class="form-control text-center @error('documentIssuedBy') is-invalid @enderror" id="documentIssuedBy" name="documentIssuedBy" value="{{ old('documentIssuedBy') }}" maxlength="255">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="documentIssuedDate" class="form-label">Document issued date:</label>
                                            <input type="date" class="form-control text-center @error('documentIssuedDate') is-invalid @enderror" id="documentIssuedDate" name="documentIssuedDate" value="{{ old('documentIssuedDate') }}" maxlength="255">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Relate booking</b></h4><br /></br />
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-body">
                                                <input type="hidden" id="target_url" name="target_url" data-route="{{ auth()->user()->hasRole('admin') ? route('admin.guests.relation') : (auth()->user()->hasRole('receptionist') ? route('receptionist.guests.relation') : '#') }}" />
                                                <div class="form-group">
                                                    <input type="text" class="form-control text-center font-weight-bold @error('roomNumber') is-invalid @enderror" id="roomNumber" placeholder="Room number" name="roomNumber">
                                                </div>
                                                <div id="searchResults">
                                                    <ul id="result" class="list-group"></ul>
                                                </div>
                                                <input type="hidden" id="selectedOrderId" name="selectedOrderId">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success w-100">Confirm guest data</button>
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
@endsection
@section('custom-scripts')
@vite(['resources/js/guests/create.js'])
@endsection