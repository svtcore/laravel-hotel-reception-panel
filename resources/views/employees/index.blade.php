@extends('layouts.header')
@section('employees_navbar_state', 'active')
@section('additional_style')
@endsection
@section('navbar_header_button')
@role('admin')
<a href="{{ route('admin.employees.create') }}" class="add-new-button">Add new employee</a>
@endrole
@role('receptionist')
<span class="header-navbar"></span>
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
                    <h4 class="text-center"><b>Employees</b></h4>
                    <table id="employees-table" class="table table-bordered table-striped mt-4">
                        <thead>
                            <tr>
                                <th class="text-center">Full name</th>
                                @role('admin')
                                    <th class="text-center">DOB</th>
                                @endrole
                                <th class="text-center">Phone number</th>
                                <th class="text-center">Position</th>
                                @role('admin')
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td class="text-center">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                @role('admin')
                                    <td class="text-center">{{ \Carbon\Carbon::parse($employee->dob)->format('d-m-Y') }}</td>
                                @endrole
                                <td class="text-center">{{ $employee->phone_number }}</td>
                                <td class="text-center">{{ ucfirst($employee->position) }}</td>
                                @role('admin')
                                <td class="text-center">{{ ucfirst($employee->status) }}</td>
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