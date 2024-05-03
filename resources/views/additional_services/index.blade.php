@extends('layouts.header')
@section('services_navbar_state', 'active')
@section('additional_style')
@endsection
@section('navbar_header_button')
<a href="{{ route('admin.services.create') }}" style="width:400px;" class="add-new-button">Add Service</a>
@endsection

@section('content')
<div class="container-fluid mt-3">
    <div class="content-container">
        <div class="content-header">
            <div class="container-fluid mt-4">
                <!-- Session Messages Handling -->
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
                <!-- Services Table -->
                <div class="mt-4 text-center">
                    <h4><b>Additional Services</b></h4>
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