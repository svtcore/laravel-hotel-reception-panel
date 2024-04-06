@extends('layouts.header')
@section('rooms_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/rooms-style.css'])
@endsection
@section('content')
<div class="container-fluid mt-3">
    <div class="content-container">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title pl-4"><b>Room Details</b></h4><br /><br />
                                <form action="{{ route('admin.rooms.update', $room_data->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="room_id" value="{{ $room_data->id }}">
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="roomNumber" class="form-label">Room number</label>
                                            <input type="text" class="form-control text-center" id="roomNumber" name="roomNumber" value="{{ $room_data->door_number }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="roomFloor" class="form-label">Floor</label>
                                            <input type="text" class="form-control text-center" id="roomFloor" name="roomFloor" value="{{ $room_data->floor }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="roomType" class="form-label">Type</label>
                                            <select class="form-select text-center" id="roomType" name="roomType">
                                                <option value="standart" {{ $room_data->type == 'standart' ? 'selected' : '' }}>Standard</option>
                                                <option value="comfort" {{ $room_data->type == 'comfort' ? 'selected' : '' }}>Comfort</option>
                                                <option value="premium" {{ $room_data->type == 'premium' ? 'selected' : '' }}>Premium</option>
                                                <option value="king" {{ $room_data->type == 'king' ? 'selected' : '' }}>King</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="roomCount" class="form-label">Room count</label>
                                            <input type="number" class="form-control text-center" id="roomCount" name="roomCount" value="{{ $room_data->room_amount }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="roomAdult" class="form-label">Adult beds</label>
                                            <input type="number" class="form-control text-center" id="roomAdult" name="roomAdult" value="{{ $room_data->bed_amount }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="roomChild" class="form-label">Child beds</label>
                                            <input type="number" class="form-control text-center" id="roomChild" name="roomChild" value="{{ $room_data->children_bed_amount }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="roomPrice" class="form-label">Price per night</label>
                                            <input type="number" class="form-control text-center" min="0" step="1" id="roomPrice" name="roomPrice" value="{{ $room_data->price }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select text-center" id="status" name="roomStatus">
                                                <option value="free" {{ $room_data->status == 'free' ? 'selected' : '' }}>
                                                    Free</option>
                                                <option value="busy" {{ $room_data->status == 'busy' ? 'selected' : '' }}>
                                                    Busy</option>
                                                <option value="maintence" {{ $room_data->status == 'maintence' ? 'selected' : '' }}>
                                                    Maintence</option>
                                                <option value="reserved" {{ $room_data->status == 'reserved' ? 'selected' : '' }}>
                                                    Reserved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body pl-4 pr-4">
                                <h4 class="card-title"><b>Additional properties</b></h4><br /><br />
                                <div class="row">
                                    @php $count = 0; @endphp
                                    @foreach ($room_properties as $prop)
                                    @php $selected = false; @endphp
                                    @foreach ($room_data->room_properties as $property)
                                    @if ($property->id == $prop->id)
                                    @php $selected = true; @endphp
                                    @endif
                                    @endforeach
                                    <div class="col-sm-4">
                                        <div class="form-check mb-3 ml-2 mr-2">
                                            <input class="form-check-input" type="checkbox" value="{{ $prop->id }}" id="property{{ $prop->id }}" name="properties[]" {{ $selected ? 'checked' : '' }}>
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
        </section>
    </div>
</div>
@section('custom-scripts')

@endsection
@endsection