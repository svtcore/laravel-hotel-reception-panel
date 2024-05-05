@extends('layouts.header')
@section('employees_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/rooms-style.css'])
@endsection
@section('navbar_header_button')
@role('admin')
<a href="{{ route('admin.employees.create') }}" style="width:400px;" class="add-new-button">Add Employee</a>
@endrole
@role('receptionist')
<span class="header-navbar">Employees</span>
@endrole
@endsection
@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <div class="content-header">
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
                <div>
                <h4 class="font-weight-bold text-center">Employees</h4>
                    <!-- Employees table -->
                    <table id="employees-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Full name</th>
                                <th class="text-center">DOB</th>
                                <th class="text-center">Phone number</th>
                                <th class="text-center">Position</th>
                                <th class="text-center">Status</th>
                                <!-- Display action column for admin users only -->
                                @role('admin')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through employees data -->
                            @foreach ($employees as $employee)
                            <tr>
                                <td class="text-center">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($employee->dob)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ $employee->phone_number }}</td>
                                <td class="text-center">{{ ucfirst($employee->position) }}</td>
                                <td class="text-center">{{ ucfirst($employee->status) }}</td>
                                <!-- Display actions for admin users only -->
                                @role('admin')
                                <td class="text-center">
                                    <form action="{{ route('admin.employees.delete', $employee->id) }}" method="POST">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a href="{{ route('admin.employees.edit', $employee->id) }}" type="button" class="btn btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                @endrole
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
@vite(['resources/js/employees/index.js'])
@endsection
@endsection