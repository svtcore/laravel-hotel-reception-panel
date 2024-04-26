@extends('layouts.header')
@section('rooms_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/rooms-style.css'])
@endsection
@section('navbar_header_button')
    <span class="header-navbar">Create new room data</span>
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="content-container">
        <!-- Main content -->
        <section class="content">
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
                <form action="{{ route('rooms.store') }}" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h4 class="card-title pl-4"><b>Room Details</b></h4><br /><br />
                                    @csrf
                                    <input type="hidden" name="room_id" value="">
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="roomNumber" class="form-label">Room number</label>
                                            <input type="text" class="form-control text-center" id="roomNumber" name="roomNumber" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="floorNumber" class="form-label">Floor</label>
                                            <input type="text" class="form-control text-center" id="floorNumber" name="floorNumber" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="type" class="form-label">Type</label>
                                            <select class="form-select text-center" id="type" name="type" required>
                                                <option value="standard">Standard</option>
                                                <option value="deluxe">Deluxe</option>
                                                <option value="suite">Suite</option>
                                                <option value="penthouse">Penthouse</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="totalRooms" class="form-label">Total rooms</label>
                                            <input type="number" class="form-control text-center" id="totalRooms" name="totalRooms" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="adultsBedsCount" class="form-label">Adult beds</label>
                                            <input type="number" class="form-control text-center" id="adultsBedsCount" name="adultsBedsCount" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="roomChild" class="form-label">Child beds</label>
                                            <input type="number" class="form-control text-center" id="childrenBedsCount" name="childrenBedsCount" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="price" class="form-label">Price per night</label>
                                            <input type="number" class="form-control text-center" min="0" step="1" id="price" name="price" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select text-center" id="status" name="status" required>
                                                <option value="available">
                                                Available</option>
                                                <option value="occupied">
                                                Occupied</option>
                                                <option value="under_maintenance">
                                                    Maintenance</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card no-shadow">
                            <div class="card-body pl-4 pr-4">
                                <h4 class="card-title"><b>Additional properties</b></h4><br /><br />
                                <div class="row">
                                    @php $count = 0; @endphp
                                    @foreach ($room_properties as $prop)
                                    <div class="col-sm-4">
                                        <div class="form-check mb-3 ml-2 mr-2">
                                            <input class="form-check-input" type="checkbox" value="{{ $prop->id }}" id="property{{ $prop->id }}" name="additionalProperties[]">
                                            <label class="form-check-label" for="property{{ $prop->id }}">
                                                {{ strtoupper($prop->name) }}
                                            </label>
                                        </div>
                                    </div>
                                    @php $count++; @endphp
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
