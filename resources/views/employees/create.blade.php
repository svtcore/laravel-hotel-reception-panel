@extends('layouts.header')
@section('title', 'Add employee')
@section('employees_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/employees-style.css'])
@endsection
@section('content')
@section('navbar_header_button')
<span id="header_employees_add">Add employee</span>
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
                <form id="editForm" class="ml-4 mr-4" action="{{ route('admin.employees.store') }}" method="POST">
                    <div class="row justify-content-center ml-5 mr-5">
                        <div class="col-md-6">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Employee information</b></h4><br /><br />
                                    @csrf
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="firstName" class="form-label">First name:</label>
                                            <input type="text" class="form-control text-center @error('firstName') is-invalid @enderror" id="firstName" name="firstName" value="{{ old('firstName') }}" required maxlength="255">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="lastName" class="form-label">Last name:</label>
                                            <input type="text" class="form-control text-center @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ old('lastName') }}" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="dob" class="form-label">DOB:</label>
                                            <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob') }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Status:</label>
                                            <select class="form-select text-center @error('status') is-invalid @enderror" id="status" name="status">
                                                <option value="active">Active</option>
                                                <option value="fired">Fired</option>
                                                <option value="vacation">On Vacation</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success w-100">Confirm data</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Details</b></h4><br /><br />
                                    <div class="row ml-2 mr-2 mb-4">
                                        <div class="col-sm-12">
                                            <label for="phoneNumber" class="form-label">Phone number:</label>
                                            <input type="number" class="form-control text-center @error('phoneNumber') is-invalid @enderror" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber') }}" required maxlength="20">
                                        </div>
                                    </div>
                                    <div class="row mb-5 ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <label for="position" class="form-label">Position:</label>
                                            <input type="text" class="form-control text-center @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}" maxlength="255">
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