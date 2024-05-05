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
                <!-- Session Messages Handling -->
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
                <!-- Services Table -->
                <div class="text-center mb-4">
                    <h4>Additional services</h4>
                </div>
                <div>
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
                                <td class="text-center">
                                    @if ($service->available != 0)
                                    YES
                                    @else
                                    NO
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.services.delete', $service->id) }}" method="POST">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <!-- Edit user button -->
                                            <a href="{{ route('admin.services.edit', $service->id) }}" type="button" class="btn btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <!-- Delete user button -->
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
</div>
</div>
@section('custom-scripts')
@vite(['resources/js/additional_services/index.js'])
@endsection

@endsection