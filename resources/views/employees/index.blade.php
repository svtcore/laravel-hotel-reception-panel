@extends('layouts.header')
@section('employees_navbar_state', 'active')
@section('additional_style')
@endsection
@section('navbar_header_button')
@role('admin')
<a href="{{ route('admin.employees.create') }}" class="add-new-button">Add new employee</a>
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
                <div>
                    <h4 class="font-weight-bold text-center">Employees</h4>
                    <table id="employees-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Full name</th>
                                <th class="text-center">DOB</th>
                                <th class="text-center">Phone number</th>
                                <th class="text-center">Position</th>
                                <th class="text-center">Status</th>
                                @role('admin')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td class="text-center">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($employee->dob)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ $employee->phone_number }}</td>
                                <td class="text-center">{{ ucfirst($employee->position) }}</td>
                                <td class="text-center">{{ ucfirst($employee->status) }}</td>
                                @role('admin')
                                <td class="text-center">
                                    <form action="{{ route('admin.employees.delete', $employee->id) }}" method="POST">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a href="{{ route('admin.employees.edit', $employee->id) }}" type="button" class="btn btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash3"></i>
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
@endsection
@section('custom-scripts')
@vite(['resources/js/employees/index.js'])
@endsection