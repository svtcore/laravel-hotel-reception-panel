@extends('layouts.header')

@section('title', 'Add Room Data')
@section('rooms_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/rooms-style.css'])
@endsection

@section('navbar_header_button')
<span id="header_add_room_data">Add room</span>
@endsection

@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <section class="content">
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

                <form action="{{ route('admin.rooms.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title"><b>Room Information</b></h4>
                                    <br /><br />
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="roomNumber" class="form-label">Room Number</label>
                                            <input type="text" class="form-control text-center @error('roomNumber') is-invalid @enderror" id="roomNumber" name="roomNumber" value="{{ old('roomNumber') }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="floorNumber" class="form-label">Floor</label>
                                            <input type="text" class="form-control text-center @error('floorNumber') is-invalid @enderror" id="floorNumber" name="floorNumber" value="{{ old('floorNumber') }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="type" class="form-label">Type</label>
                                            <select class="form-select text-center @error('type') is-invalid @enderror" id="type" name="type" required>
                                                <option value="standard" selected>Standard</option>
                                                <option value="deluxe">Deluxe</option>
                                                <option value="suite">Suite</option>
                                                <option value="penthouse">Penthouse</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="totalRooms" class="form-label">Total Rooms</label>
                                            <input type="number" class="form-control text-center @error('totalRooms') is-invalid @enderror" id="totalRooms" name="totalRooms" value="{{ old('totalRooms') }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="adultsBedsCount" class="form-label">Adult Beds</label>
                                            <input type="number" class="form-control text-center @error('adultsBedsCount') is-invalid @enderror" id="adultsBedsCount" name="adultsBedsCount" value="{{ old('adultsBedsCount') }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="childrenBedsCount" class="form-label">Child Beds</label>
                                            <input type="number" class="form-control text-center @error('childrenBedsCount') is-invalid @enderror" id="childrenBedsCount" name="childrenBedsCount" value="{{ old('childrenBedsCount') }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="price" class="form-label">Price per Night</label>
                                            <input type="number" class="form-control text-center @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" min="0" step="1" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select text-center @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="available" selected>Available</option>
                                                <option value="occupied">Occupied</option>
                                                <option value="under_maintenance">Maintenance</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Confirm Room Data</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title"><b>Additional Properties</b></h4>
                                    <br /><br />
                                    <div class="row">
                                        @foreach ($room_properties as $prop)
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $prop->id }}" id="property{{ $prop->id }}" name="additionalProperties[]">
                                                <label class="form-check-label" for="property{{ $prop->id }}">{{ strtoupper($prop->name) }}</label>
                                            </div>
                                        </div>
                                        @if ($loop->iteration % 3 == 0)
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
            </div>
        </section>
    </div>
</div>
@endsection
