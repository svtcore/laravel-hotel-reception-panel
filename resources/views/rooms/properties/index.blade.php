@extends('layouts.header')
@section('title', 'Room properties')
@section('room_properties_navbar_state', 'active')
@section('additional_style')
@endsection
@section('navbar_header_button')
<a href="{{ route('admin.rooms.properties.create') }}" class="add-new-button">Add new room property</a>
@endsection

@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
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
                <div class="mt-4 text-center">
                    <h4><b>Room additional properties</b></h4>
                </div>
                <div>
                    <table id="properties-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Available</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $property)
                            <tr>
                                <td class="text-center">{{ $property->name }}</td>
                                <td class="text-center">
                                    @if ($property->available != 0)
                                    YES
                                    @else
                                    NO
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.rooms.properties.delete', $property->id) }}" method="POST">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <!-- Edit user button -->
                                            <a href="{{ route('admin.rooms.properties.edit', $property->id) }}" type="button" class="btn btn-warning">
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
@vite(['resources/js/rooms/properties/index.js'])
@endsection

@endsection