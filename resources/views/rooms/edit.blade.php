@extends('layouts.header')
@section('title', 'Edit room data')
@section('rooms_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/rooms-style.css'])
@endsection
@section('content')
@section('navbar_header_button')
    <span class="header-navbar">Edit room data</span>
@endsection
<div class="container-fluid">
    <div class="content-container main-container">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid mt-4">
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
                <!-- Form to update room details -->
                <form action="{{ route('admin.rooms.update', $room_data->id) }}" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="card-title pl-4"><b>Room information</b></h4><br /><br />
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="room_id" value="{{ $room_data->id }}">
                                    <!-- Room details inputs -->
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="roomNumber" class="form-label">Room number:</label>
                                            <!-- Input for room number -->
                                            <input type="text" class="form-control text-center @error('roomNumber') is-invalid @enderror" id="roomNumber" name="roomNumber" value="{{ $room_data->room_number }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="floorNumber" class="form-label">Floor:</label>
                                            <!-- Input for floor number -->
                                            <input type="text" class="form-control text-center @error('floorNumber') is-invalid @enderror" id="floorNumber" name="floorNumber" value="{{ $room_data->floor_number }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="type" class="form-label">Type:</label>
                                            <!-- Select room type -->
                                            <select class="form-select text-center @error('type') is-invalid @enderror" id="type" name="type" required>
                                                <option value="standard" {{ $room_data->type == 'standard' ? 'selected' : '' }}>Standard</option>
                                                <option value="deluxe" {{ $room_data->type == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                                <option value="suite" {{ $room_data->type == 'suite' ? 'selected' : '' }}>Suite</option>
                                                <option value="penthouse" {{ $room_data->type == 'penthouse' ? 'selected' : '' }}>Penthouse</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="totalRooms" class="form-label">Total rooms:</label>
                                            <!-- Input for total number of rooms -->
                                            <input type="number" class="form-control text-center @error('totalRooms') is-invalid @enderror" id="totalRooms" name="totalRooms" value="{{ $room_data->total_rooms }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="adultsBedsCount" class="form-label">Adult beds:</label>
                                            <!-- Input for number of adult beds -->
                                            <input type="number" class="form-control text-center @error('adultsBedsCount') is-invalid @enderror" id="adultsBedsCount" name="adultsBedsCount" value="{{ $room_data->adults_beds_count }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="roomChild" class="form-label">Child beds:</label>
                                            <!-- Input for number of child beds -->
                                            <input type="number" class="form-control text-center @error('childrenBedsCount') is-invalid @enderror" id="childrenBedsCount" name="childrenBedsCount" value="{{ $room_data->children_beds_count }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="price" class="form-label">Price per night:</label>
                                            <!-- Input for price per night -->
                                            <input type="number" class="form-control text-center @error('price') is-invalid @enderror" min="0" step="1" id="price" name="price" value="{{ $room_data->price }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Status:</label>
                                            <!-- Select room status -->
                                            <select class="form-select text-center @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="available" {{ $room_data->status == 'available' ? 'selected' : '' }}>
                                                Available</option>
                                                <option value="occupied" {{ $room_data->status == 'occupied' ? 'selected' : '' }}>
                                                Occupied</option>
                                                <option value="under_maintenance" {{ $room_data->status == 'under_maintenance' ? 'selected' : '' }}>
                                                    Maintenance</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <!-- Button to submit form -->
                                            <button type="submit" class="btn btn-primary w-100">Save changes</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- Additional properties -->
                    <div class="col-md-6">
                        <div class="card no-shadow">
                            <div class="card-body pl-4 pr-4">
                                <h4 class="card-title"><b>Additional properties</b></h4><br /><br />
                                <div class="row">
                                    @php $count = 0; @endphp
                                    <!-- Loop through room properties -->
                                    @foreach ($room_properties as $prop)
                                    @php $selected = false; @endphp
                                    <!-- Check if property is selected -->
                                    @foreach ($room_data->room_properties as $property)
                                    @if ($property->id == $prop->id)
                                    @php $selected = true; @endphp
                                    @endif
                                    @endforeach
                                    <div class="col-sm-4">
                                        <div class="form-check mb-3 ml-2 mr-2">
                                            <!-- Checkbox for each property -->
                                            <input class="form-check-input" type="checkbox" value="{{ $prop->id }}" id="property{{ $prop->id }}" name="additionalProperties[]" {{ $selected ? 'checked' : '' }}>
                                            <label class="form-check-label" for="property{{ $prop->id }}">
                                                <!-- Display property name -->
                                                {{ strtoupper($prop->name) }}
                                            </label>
                                        </div>
                                    </div>
                                    @php $count++; @endphp
                                    <!-- Check if a new row needs to be started -->
                                    @if ($count % 3 == 0)
                                </div>
                                <div class="row">
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
        </section>
    </div>
</div>
@endsection
