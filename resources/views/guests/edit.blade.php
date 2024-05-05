@extends('layouts.header')
@section('title', 'Edit guest information')
@section('guests_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/guests-style.css'])
@endsection
@section('content')
@section('navbar_header_button')
<span class="header-navbar">Edit guest data</span>
@endsection
<div class="container-fluid">
    <div class="content-container main-container">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Display success message if any -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <!-- Display error messages if any -->
                @if ($errors->any())
                <div class="custom-error-message">
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <!-- Form for editing guest details by admin -->
                @role('admin')
                <form id="editForm" action="{{ route('admin.guests.update', $guest->id) }}" method="POST">
                    @endrole
                    <!-- Form for editing guest details by receptionist -->
                    @role('receptionist')
                    <form id="editForm" action="{{ route('receptionist.guests.update', $guest->id) }}" method="POST">
                        @endrole
                        <div class="row">
                            <div class="col-md-5">
                                <div class="card no-shadow">
                                    <div class="card-body">
                                        <h4 class="card-title pl-4"><b>Guest information</b></h4><br /><br />
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="guest_id" value="{{ $guest->id }}">
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-6">
                                                <label for="firstName" class="form-label">First name:</label>
                                                <input type="text" class="form-control text-center @error('firstName') is-invalid @enderror" id="firstName" name="firstName" value="{{ $guest->first_name }}"  maxlength="255" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="lastName" class="form-label">Last name:</label>
                                                <input type="text" class="form-control text-center @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ $guest->last_name }}"  maxlength="255" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-6">
                                                <label for="gender" class="form-label">Gender:</label>
                                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                                    <option value="M" {{ $guest->gender == 'M' ? 'selected' : '' }}>Male</option>
                                                    <option value="F" {{ $guest->gender == 'F' ? 'selected' : '' }}>Female</option>
                                                    <option value="N" {{ $guest->gender == 'N' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="dob" class="form-label">DOB:</label>
                                                <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ $guest->dob }}" required>
                                            </div>
                                        </div>
                                        <div class="row ml-2 mr-2 mb-3">
                                            <div class="col-sm-12">
                                                <label for="phoneNumber" class="form-label">Phone number:</label>
                                                <input type="number" class="form-control text-center @error('phoneNumber') is-invalid @enderror" id="phoneNumber" name="phoneNumber" value="{{ $guest->phone_number }}" required maxlength="20">
                                            </div>
                                        </div>
                                        <div class="row ml-2 mr-2">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-primary w-100">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card no-shadow">
                                    <div class="card-body">
                                        <h4 class="card-title pl-4"><b>Document</b></h4><br /><br />
                                        <input type="hidden" name="guest_id" value="{{ $guest->id }}">
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-6">
                                                <input type="hidden" id="documentCountry" @isset($guest->guest_document->document_country) value="{{ $guest->guest_document->document_country }}" @endisset > <label for="countryCode" class="form-label">Country:</label>
                                                <select class="form-select @error('countryCode') is-invalid @enderror" id="countryCode" name="countryCode">
                                                    <option value="">Select Country Code</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3 ml-2 mr-2">
                                            <div class="col-sm-4">
                                                <label for="documentSerial" class="form-label">Document serial:</label>
                                                <input type="text" class="form-control text-center @error('documentSerial') is-invalid @enderror" id="documentSerial" name="documentSerial" @isset($guest->guest_document->document_serial) value="{{ $guest->guest_document->document_serial }}" @endisset maxlength="255">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="documentNumber" class="form-label">Doc. number:</label>
                                                <input type="text" class="form-control text-center @error('documentNumber') is-invalid @enderror" id="documentNumber" name="documentNumber" @isset($guest->guest_document->document_number) value="{{ $guest->guest_document->document_number }}" @endisset maxlength="255">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="documentExpired" class="form-label">Document expired:</label>
                                                <input type="date" class="form-control text-center @error('documentExpired') is-invalid @enderror" id="documentExpired" name="documentExpired" @isset($guest->guest_document->document_expired) value="{{ $guest->guest_document->document_expired }} @endisset">
                                            </div>
                                        </div>
                                        <div class="row mb-5 ml-2 mr-2">
                                            <div class="col-sm-8">
                                                <label for="documentIssuedBy" class="form-label">Document issued by:</label>
                                                <input type="text" class="form-control text-center @error('documentIssuedBy') is-invalid @enderror" id="documentIssuedBy" name="documentIssuedBy" @isset($guest->guest_document->document_issued_by) value="{{ $guest->guest_document->document_issued_by }}" @endisset maxlength="255">
                                            </div>
                                            <div class="col-sm-4 mb-1">
                                                <label for="documentIssuedDate" class="form-label">Document issued date</label>
                                                <input type="date" class="form-control text-center @error('documentIssuedDate') is-invalid @enderror" id="documentIssuedDate" name="documentIssuedDate" @isset($guest->guest_document->document_issued_date) value="{{ $guest->guest_document->document_issued_date }}" @endisset>
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
@vite(['resources/js/guests/edit.js'])
@endsection
@endsection