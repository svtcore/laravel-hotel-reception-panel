@extends('layouts.header')
@section('employees_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/guests-style.css'])
@endsection
@section('content')
@section('navbar_header_button')
<span class="nav-page-info">Edit employee data</span>
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
                <form id="editForm" class="ml-4 mr-4 mt-5" action="{{ route('admin.employees.store') }}" method="POST">
                    <div class="row justify-content-center ml-5 mr-5">
                        <div class="col-md-6">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Employee data</b></h4><br /><br />
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
                                            <label for="dob" class="form-label">DOB</label>
                                            <input type="date" class="form-control" id="dob" name="dob" value="" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select text-center" id="status" name="status">
                                                <option value="active">Active</option>
                                                <option value="fired">Fired</option>
                                                <option value="vacation">On Vacation</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary w-100">Confirm data</button>
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
                                            <label for="phoneNumber" class="form-label">Phone number</label>
                                            <input type="text" class="form-control text-center" id="phoneNumber" name="phoneNumber" value="" required maxlength="20">
                                        </div>
                                    </div>
                                    <div class="row mb-5 ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <label for="position" class="form-label">Position</label>
                                            <input type="text" class="form-control text-center" id="position" name="position" value="" maxlength="255">
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