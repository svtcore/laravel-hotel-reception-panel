@extends('layouts.header')
@section('guests_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/guests-style.css'])
@endsection
@section('content')
@section('navbar_header_button')
<span class="nav-page-info">Add new guest</span>
@endsection
<div class="container-fluid mt-5">
    <div class="content-container">
        <!-- Main content -->
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
                <form id="addForm" action="{{ route('admin.guests.store') }}" method="POST">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Guest Details</b></h4><br /><br />
                                    @csrf
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control text-center" id="firstName" name="firstName" value="" required maxlength="255">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control text-center" id="lastName" name="lastName" value="" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select" id="gender" name="gender" required>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                                <option value="N">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="dob" class="form-label">DOB</label>
                                            <input type="date" class="form-control" id="dob" name="dob" value="" required>
                                        </div>
                                    </div>
                                    <div class="row ml-2 mr-2 mb-3">
                                        <div class="col-sm-12">
                                            <label for="phoneNumber" class="form-label">Phone number</label>
                                            <input type="text" class="form-control text-center" id="phoneNumber" name="phoneNumber" value="" maxlength="20">
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
                                            <input type="hidden" id="documentCountry" value=""> <label for="countryCode" class="form-label">Country</label>
                                            <select class="form-select" id="countryCode" name="countryCode">
                                                <option value="">Select Country Code</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-4">
                                            <label for="documentSerial" class="form-label">Document Serial</label>
                                            <input type="text" class="form-control text-center" id="documentSerial" name="documentSerial" value="" maxlength="255">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="documentNumber" class="form-label">Doc. number</label>
                                            <input type="text" class="form-control text-center" id="documentNumber" name="documentNumber" value="" maxlength="255">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="documentExpired" class="form-label">Document Expired</label>
                                            <input type="date" class="form-control text-center" id="documentExpired" name="documentExpired" value="">
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-8">
                                            <label for="documentIssuedBy" class="form-label">Document Issued By</label>
                                            <input type="text" class="form-control text-center" id="documentIssuedBy" name="documentIssuedBy" value="" maxlength="255">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="documentIssuedDate" class="form-label">Document Issued Date</label>
                                            <input type="date" class="form-control text-center" id="documentIssuedDate" name="documentIssuedDate" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Relatate booking</b></h4><br /></br />
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-body">
                                                <input type="hidden" id="target_url" name="target_url" data-route="{{ route('admin.guests.relation') }}" />
                                                <div class="form-group">
                                                    <input type="text" class="form-control text-center font-weight-bold" id="roomNumber" placeholder="Room number" name="roomNumber">
                                                </div>
                                                <div id="searchResults" style="max-height: 200px; overflow-y: auto;">
                                                    <ul id="result" class="list-group"></ul>
                                                </div>
                                                <input type="hidden" id="selectedOrderId" name="selectedOrderId">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary w-100">Save all guest data</button>
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
@vite(['resources/js/guests/create.js'])
@endsection
@endsection