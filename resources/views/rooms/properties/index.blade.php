@extends('layouts.header')
@section('title', 'Room Properties')
@section('room_properties_navbar_state', 'active')
@section('additional_style')
@endsection
@section('navbar_header_button')
<a href="{{ route('admin.rooms.properties.create') }}" class="add-new-button">Add room property</a>
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
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="text-center">
                    <h4><b>Room additional properties</b></h4>
                </div>

                <div class="table-responsive">
                    <table id="properties-table" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Available</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($properties as $property)
                            <tr>
                                <td class="text-center">{{ $property->name }}</td>
                                <td class="text-center">{{ $property->available ? 'YES' : 'NO' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.rooms.properties.delete', $property->id) }}" method="POST" class="d-inline">
                                        <a href="{{ route('admin.rooms.properties.edit', $property->id) }}" class="btn btn-warning">
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
</div>
@endsection

@section('custom-scripts')
@vite(['resources/js/rooms/properties/index.js'])
@endsection