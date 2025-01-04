@extends('layouts.header')
@section('title', 'Edit employee data')
@section('employees_navbar_state', 'active')

@section('additional_style')
@vite(['resources/css/employees-style.css'])
@endsection
@section('content')
@section('navbar_header_button')
<span id="header_employees_edit">Edit employee</span>
@endsection
<div class="container-fluid">
    <div class="content-container main-container">
        <section class="content">
            <div class="container-fluid mt-4">
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
                <form id="editForm" class="ml-4 mr-4 mt-5" action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
                    <div class="row justify-content-center ml-5 mr-5">
                        <div class="col-md-6">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Employee information</b></h4><br /><br />
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="firstName" class="form-label">First name:</label>
                                            <input type="text" class="form-control text-center @error('firstName') is-invalid @enderror" id="firstName" name="firstName" value="{{ $employee->first_name }}" maxlength="255" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="lastName" class="form-label">Last name:</label>
                                            <input type="text" class="form-control text-center @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ $employee->last_name }}" maxlength="255" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="dob" class="form-label">DOB:</label>
                                            <input type="date" class="form-control @error('lastName') is-invalid @enderror" id="dob" name="dob" value="{{ $employee->dob }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Status:</label>
                                            <select class="form-select text-center @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="fired" {{ $employee->status == 'fired' ? 'selected' : '' }}>Fired</option>
                                                <option value="vacation" {{ $employee->status == 'vacation' ? 'selected' : '' }}>On Vacation</option>
                                                <option value="other" {{ $employee->status == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success w-100">Save changes</button>
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
                                            <input type="number" class="form-control text-center @error('phoneNumber') is-invalid @enderror" id="phoneNumber" name="phoneNumber" value="{{ $employee->phone_number }}" maxlength="20" required>
                                        </div>
                                    </div>
                                    <div class="row mb-5 ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <label for="position" class="form-label">Position:</label>
                                            <input type="text" class="form-control text-center @error('position') is-invalid @enderror" id="position" name="position" value="{{ $employee->position }}" maxlength="255" required>
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
@endsection