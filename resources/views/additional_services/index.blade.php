@extends('layouts.header')
@section('title', 'Additional services')
@section('services_navbar_state', 'active')
@section('additional_style')
@endsection

@section('navbar_header_button')
<a href="{{ route('admin.services.create') }}" class="add-new-button">Add service</a>
@endsection

@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <div class="content-header">
            <div class="container-fluid">
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
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
                <div class="text-center mb-4">
                    <h4>Additional services</h4>
                </div>
                <table id="services-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Available</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                        <tr>
                            <td class="text-center">{{ $service->name }}</td>
                            <td class="text-center">{{ $service->price }}</td>
                            <td class="text-center">{{ $service->available ? 'YES' : 'NO' }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.services.delete', $service->id) }}" method="POST" class="d-inline">
                                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
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
@endsection

@section('custom-scripts')
@vite(['resources/js/additional_services/index.js'])
@endsection
