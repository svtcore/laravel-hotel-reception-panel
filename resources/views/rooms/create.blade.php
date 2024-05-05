@extends('layouts.header')
@section('title', 'Add room data')
@section('rooms_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/rooms-style.css'])
@endsection
@section('navbar_header_button')
<span class="header-navbar">Add new room data</span>
@endsection
@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <!-- Main content -->
        <section class="content">
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
                <!-- Form to add a new room -->
                <form action="{{ route('admin.rooms.store') }}" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="card-title pl-4"><b>Room information</b></h4><br /><br />
                                    @csrf
                                    <input type="hidden" name="room_id" value="">
                                    <!-- Room details inputs -->
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="roomNumber" class="form-label">Room number:</label>
                                            <input type="text" class="form-control text-center @error('roomNumber') is-invalid @enderror" id="roomNumber" name="roomNumber" value="{{ old('roomNumber') }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="floorNumber" class="form-label">Floor:</label>
                                            <input type="text" class="form-control text-center @error('floorNumber') is-invalid @enderror" id="floorNumber" name="floorNumber" value="{{ old('floorNumber') }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="type" class="form-label">Type:</label>
                                            <!-- Select room type -->
                                            <select class="form-select text-center @error('type') is-invalid @enderror" id="type" name="type" required>
                                                <option value="standard" selected>Standard</option>
                                                <option value="deluxe">Deluxe</option>
                                                <option value="suite">Suite</option>
                                                <option value="penthouse">Penthouse</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="totalRooms" class="form-label">Total rooms</label>
                                            <!-- Input for total number of rooms -->
                                            <input type="number" class="form-control text-center @error('totalRooms') is-invalid @enderror" id="totalRooms" name="totalRooms" value="{{ old('totalRooms') }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="adultsBedsCount" class="form-label">Adult beds</label>
                                            <!-- Input for number of adult beds -->
                                            <input type="number" class="form-control text-center @error('adultsBedsCount') is-invalid @enderror" id="adultsBedsCount" name="adultsBedsCount" value="{{ old('adultsBedsCount') }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="roomChild" class="form-label">Child beds</label>
                                            <!-- Input for number of child beds -->
                                            <input type="number" class="form-control text-center @error('childrenBedsCount') is-invalid @enderror" id="childrenBedsCount" name="childrenBedsCount" value="{{ old('childrenBedsCount') }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="price" class="form-label">Price per night</label>
                                            <!-- Input for price per night -->
                                            <input type="number" class="form-control text-center @error('price') is-invalid @enderror" min="0" step="1" id="price" name="price" value="{{ old('price') }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Status</label>
                                            <!-- Select room status -->
                                            <select class="form-select text-center @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="available" selected>Available</option>
                                                <option value="occupied">Occupied</option>
                                                <option value="under_maintenance">Maintenance</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <!-- Button to submit form -->
                                            <button type="submit" class="btn btn-primary w-100">Confirm room data</button>
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
                                    <div class="col-sm-4">
                                        <div class="form-check mb-3 ml-2 mr-2">
                                            <!-- Checkbox for each property -->
                                            <input class="form-check-input" type="checkbox" value="{{ $prop->id }}" id="property{{ $prop->id }}" name="additionalProperties[]">
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
