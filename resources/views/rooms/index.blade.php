@extends('layouts.header')
@section('title', 'Rooms')
@section('rooms_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/rooms-style.css'])
@endsection

@section('navbar_header_button')
@if(auth()->user()->hasRole('admin'))
<a href="{{ route('admin.rooms.create') }}" class="add-new-button">Add room</a>
@else
<span class="header-navbar">Rooms</span>
@endif
@endsection

@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <div class="content-header">
            <div class="container-fluid">
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

                <div class="content-container text-center">
                    <h4 class="font-weight-bold">Search form</h4>
                    <form id="searchForm" method="POST" action="{{ route(auth()->user()->hasRole('admin') ? 'admin.rooms.search' : (auth()->user()->hasRole('receptionist') ? 'receptionist.rooms.search' : '#')) }}">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <label class="toggle">
                                    <input class="toggle-checkbox" id="switch-by-number" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label">By number</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="toggle">
                                    <input class="toggle-checkbox" id="switch-by-guest" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label">By guest name</span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 pt-2">
                                <input type="text" class="form-control text-center @error('roomNumber') is-invalid @enderror" id="roomNumber" name="roomNumber" placeholder="Room number" disabled required maxlength="255">
                            </div>
                            <div class="col-md-4 pt-2">
                                <input type="text" class="form-control text-center @error('guestName') is-invalid @enderror" id="guestName" name="guestName" placeholder="Guest name" disabled required maxlength="255">
                            </div>
                            <div class="col-md-6 mt-2 d-none" id="searchTopBlock">
                                <button type="submit" class="btn btn-primary w-100" name="searchTopBlock" id="searchTopBlock">Search</button>
                            </div>
                        </div>

                        <div id="baseSearch">
                            <hr />
                            <div class="row">
                                <div class="col-md-3 mb-2 date-block">
                                    <label for="startDate">Start date</label>
                                    <input type="date" class="form-control @error('startDate') is-invalid @enderror" id="startDate" name="startDate" value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                </div>
                                <div class="col-md-3 mb-2 date-block">
                                    <label for="endDate">End date</label>
                                    <input type="date" class="form-control @error('endDate') is-invalid @enderror" id="endDate" name="endDate" value="{{ \Carbon\Carbon::now()->addDay()->toDateString() }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 pt-2">
                                    <label for="type">Type</label>
                                    <select class="form-select text-center @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="0">Any</option>
                                        <option value="standard">Standard</option>
                                        <option value="deluxe">Deluxe</option>
                                        <option value="suite">Suite</option>
                                        <option value="penthouse">Penthouse</option>
                                    </select>
                                </div>
                                <div class="col-md-2 pt-2">
                                    <label for="status">Status</label>
                                    <select class="form-select text-center @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="0">Any</option>
                                        <option value="available">Available</option>
                                        <option value="occupied">Occupied</option>
                                        <option value="under_maintenance">Maintenance</option>
                                    </select>
                                </div>
                                <div class="col-md-2 pt-2">
                                    <label for="adultsBedsCount">Adults beds</label>
                                    <select class="form-select text-center @error('adultsBedsCount') is-invalid @enderror" id="adultsBedsCount" name="adultsBedsCount" required>
                                        <option value="0">Any</option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }} persons</option>
                                            @endfor
                                    </select>
                                </div>
                                <div class="col-md-2 pt-2">
                                    <label for="childrenBedsCount">Children beds</label>
                                    <select class="form-select text-center @error('childrenBedsCount') is-invalid @enderror" id="childrenBedsCount" name="childrenBedsCount" required>
                                        <option value="-1" selected>Any</option>
                                        <option value="0">NO CHILD BED</option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }} child bed</option>
                                            @endfor
                                    </select>
                                </div>
                                <div class="col-md-4 mt-4 pt-2" id="searchBlock">
                                    <button type="submit" class="btn btn-primary w-100" name="searchButton" id="searchButton">Search</button>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-12 pt-2">
                                    <div class="border rounded p-3">
                                        <div class="border-bottom pb-2 mb-3">
                                            <button class="btn btn-outline-secondary w-100 font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProperties" aria-expanded="false" aria-controls="collapseProperties">
                                                Include additional properties
                                            </button>
                                        </div>
                                        <div class="collapse" id="collapseProperties">
                                            @foreach ($room_properties as $property)
                                            <div class="form-check form-check-inline m-3 font-weight-bold">
                                                <input class="form-check-input mt-1 mr-2" type="checkbox" id="property_{{ $property->id }}" value="{{ $property->id }}" name="additionalProperties[]">
                                                <label class="form-check-label" for="property_{{ $property->id }}">{{ strtoupper($property->name) }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="mt-4 text-center">
                    <h4><b>Available rooms</b></h4>
                </div>

                <div id="main-container">
                    <table id="free-rooms-table" class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">Room №</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Floor</th>
                                <th class="text-center">Beds</th>
                                <th class="text-center">Price/per night</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $room)
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.rooms.show' : (auth()->user()->hasRole('receptionist') ? 'receptionist.rooms.show' : '#'), $room->id) }}">
                                        {{ $room->room_number }}
                                    </a>
                                </td>
                                <td class="text-center">{{ strtoupper($room->type) }}</td>
                                <td class="text-center">{{ $room->floor_number }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary badge-big fs-7">{{ $room->adults_beds_count }}</span>
                                    @if ($room->children_beds_count > 0)
                                    <span class="badge bg-success badge-big fs-7"><i class="bi bi-person-arms-up"></i></span>
                                    @endif
                                </td>
                                <td class="text-center"><b>{{ $room->price }}</b></td>
                                <td class="text-center" id="rooms_table_action">
                                    <div class="btn-group" role="group" aria-label="Room actions">
                                        @if ($room->status == "available")
                                        <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.booking.create' : (auth()->user()->hasRole('receptionist') ? 'receptionist.booking.create' : '#'), $room->id) }}" class="btn btn-success">Book now</a>
                                        @endif
                                        <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.rooms.show' : (auth()->user()->hasRole('receptionist') ? 'receptionist.rooms.show' : '#'), $room->id) }}" class="btn btn-secondary">Details</a>
                                        @if(auth()->user()->hasRole('admin'))
                                        <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('admin.rooms.delete', $room->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger h-100" id="rooms-delete-button"><i class="bi bi-trash3"></i></button>
                                        </form>
                                        @endif
                                    </div>
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
@vite(['resources/js/rooms/index.js'])
@endsection