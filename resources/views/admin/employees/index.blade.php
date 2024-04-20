@extends('layouts.header')
@section('employees_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/rooms-style.css'])
@endsection
@section('navbar_header_button')
<a href="{{ route('admin.employees.create') }}" class="add-new-button">Add Employee</a>
@endsection
@section('content')
<div class="container-fluid mt-3">
    <div class="content-container">
        <div class="content-header">
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
                <div class="mt-4 text-center">
                    <h4><b>Employees</b></h4>
                </div>
                <div>
                    <table id="employees-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Full name</th>
                                <th class="text-center">DOB</th>
                                <th class="text-center">Phone number</th>
                                <th class="text-center">Position</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
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
