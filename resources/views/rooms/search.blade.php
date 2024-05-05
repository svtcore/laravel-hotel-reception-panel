@extends('layouts.header')
@section('rooms_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/rooms-style.css'])
@endsection
@section('navbar_header_button')
@role('admin')
<a href="{{ route('admin.rooms.create') }}" class="add-new-button">Add new room</a>
@endrole
@role('receptionist')
<span class="header-navbar">Rooms</span>
@endrole
@endsection
@section('content')
<div class="container-fluid">
    <!-- Main container -->
    <div class="content-container main-container">
        <!-- Content container -->
        <div class="content-header">
            <!-- Content header -->
            <div class="container-fluid">
                <!-- Inner container -->
                @if (session('success'))
                <div class="alert alert-success">
                    <!-- Success notification -->
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
                    <!-- Content container -->
                    <h4 class="font-weight-bold">Search form</h4>
                    <!-- Search form -->
                    @role('admin')
                    <form id="searchForm" method="POST" action="{{ route('admin.rooms.search') }}">
                        @endrole
                        @role('receptionist')
                        <form id="searchForm" method="POST" action="{{ route('receptionist.rooms.search') }}">
                            @endrole
                            @csrf
                            <div class="row mt-4">
                                <!-- Toggles -->
                                <div class="col-md-2">
                                    <label class="toggle">
                                        <input class="toggle-checkbox" id="switch-by-number" type="checkbox" @if (isset($inputData['roomNumber'])) checked @endif>
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">By number</span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="toggle">
                                        <input class="toggle-checkbox" id="switch-by-guest" type="checkbox" @if (isset($inputData['guestName'])) checked @endif>
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">By guest name</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-2 pt-2">
                                    <label for="roomNumber"></label>
                                    <input type="text" class="form-control text-center @error('roomNumber') is-invalid @enderror" id="roomNumber" name="roomNumber" placeholder="Room number" @if (!isset($inputData['roomNumber'])) disabled @else value="{{ $inputData['roomNumber'] }}" @endif required>
                                </div>
                                <div class="col-md-4 pt-2">
                                    <label for="guestName"></label>
                                    <input type="text" class="form-control text-center @error('guestName') is-invalid @enderror" id="guestName" name="guestName" placeholder="Guest name" @if (!isset($inputData['guestName'])) disabled @else value="{{ $inputData['guestName'] }}" @endif required>
                                </div>
                                <div class="col-md-6 mt-2 @if (!isset($inputData['roomNumber']) || !isset($inputData['roomNumber'])) d-none @endif " id="searchTopBlock">
                                    <label for="searchTopBlock"></label>
                                    <button type="submit" class="btn btn-primary w-100" name="searchTopBlock" id="searchTopBlock">Search</button>
                                </div>
                            </div>
                            <div id="baseSearch" @if (isset($inputData['roomNumber']) || isset($inputData['roomNumber'])) class="d-none" @endif>
                                <hr />
                                <div class="form-row">
                                    <div class="col-md-2 mb-2 date-block">
                                        <label for="startDate">Start date</label>
                                        <input type="date" class="form-control @error('startDate') is-invalid @enderror" id="startDate" name="startDate" @if (isset($inputData['startDate'])) value="{{ $inputData['startDate'] }}" @else value="{{ \Carbon\Carbon::now()->toDateString() }}" @endif required>
                                    </div>
                                    <div class="col-md-2 mb-2 date-block">
                                        <label for="endDate">End date</label>
                                        <input type="date" class="form-control @error('endDate') is-invalid @enderror" id="endDate" name="endDate" @if (isset($inputData['endDate'])) value="{{ $inputData['endDate'] }}" @else value="{{ \Carbon\Carbon::now()->toDateString() }}" @endif required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2 pt-2">
                                        <label for="type">Type</label>
                                        <select class="form-select text-center @error('type') is-invalid @enderror" id="type" name="type" required>
                                            <option value="0" @if (isset($inputData['type']) && $inputData['type']==0) selected @endif>Any</option>
                                            <option value="standard" @if (isset($inputData['type']) && $inputData['type']=='standard' ) selected @endif>Standard</option>
                                            <option value="deluxe" @if (isset($inputData['type']) && $inputData['type']=='deluxe' ) selected @endif>Deluxe</option>
                                            <option value="suite" @if (isset($inputData['type']) && $inputData['type']=='suite' ) selected @endif>Suite</option>
                                            <option value="penthouse" @if (isset($inputData['roomType']) && $inputData['roomType']=='penthouse' ) selected @endif>Penthouse</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <label for="status">Status</label>
                                        <select class="form-select text-center @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="0" @if (isset($inputData['status']) && $inputData['status']==0) selected @endif>Any</option>
                                            <option value="free" @if (isset($inputData['status']) && $inputData['status']=='free' ) selected @endif>Available</option>
                                            <option value="busy" @if (isset($inputData['status']) && $inputData['status']=='occupied' ) selected @endif>Occupied</option>
                                            <option value="under_maintenance" @if (isset($inputData['status']) && $inputData['status']=='under_maintenance' ) selected @endif>Maintenance</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <label for="adultsBedsCount">Adults</label>
                                        <select class="form-select text-center @error('adultsBedsCount') is-invalid @enderror" id="adultsBedsCount" name="adultsBedsCount" required>
                                            <option value="0" @if (isset($inputData['adultsBedsCount']) && $inputData['adultsBedsCount']==0) selected @endif>Any</option>
                                            @for ($i = 1; $i <= 10; $i++) <option value="{{ $i }}" @if (isset($inputData['adultsBedsCount']) && $inputData['adultsBedsCount']==$i) selected @endif>{{ $i }} person{{ $i > 1 ? 's' : '' }}</option> @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <label for="childrenBedsCount">Child bed</label>
                                        <select class="form-select text-center @error('childrenBedsCount') is-invalid @enderror" id="childrenBedsCount" name="childrenBedsCount" required>
                                            <option value="-1" @if (isset($inputData['childrenBedsCount']) && $inputData['childrenBedsCount']==-1) selected @endif>Any</option>
                                            <option value="0" @if (isset($inputData['childrenBedsCount']) && $inputData['childrenBedsCount']==0) selected @endif>NO CHILD BED</option>
                                            @for ($i = 1; $i <= 10; $i++) <option value="{{ $i }}" @if (isset($inputData['childrenBedsCount']) && $inputData['childrenBedsCount']==$i) selected @endif>{{ $i }} child bed{{ $i > 1 ? 's' : '' }}</option> @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4 pt-3" id="searchBlock">
                                        <label for="searchButton"></label>
                                        <button type="submit" class="btn btn-primary w-100" name="searchButton" id="searchButton">Search</button>
                                    </div>
                                </div>
                                <div class="form-row mt-1">
                                    <div class="col-md-12 pt-2">
                                        <div class="border rounded p-3">
                                            <div class="border-bottom pb-2 mb-3">
                                                <button class="btn btn-outline-secondary w-100 font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProperties" aria-expanded="true" aria-controls="collapseProperties">
                                                    Include additional properties
                                                </button>
                                            </div>
                                            <div class="collapsed collapse show" id="collapseProperties">
                                                @foreach ($room_properties as $property)
                                                <div class="form-check form-check-inline m-3 font-weight-bold">
                                                    <input class="form-check-input mt-1 mr-2" type="checkbox" id="property_{{ $property->id }}" value="{{ $property->id }}" name="additionalProperties[]" @if (isset($inputData['additionalProperties']) && in_array($property->id, $inputData['additionalProperties'])) checked @endif>
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
                    <h4><b>Search results</b></h4>
                </div>
                <div id="main-container">
                    <!-- Main table container -->
                    <table id="free-rooms-table" class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">Room №</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Floor</th>
                                <th class="text-center">Beds</th>
                                <th class="text-center">Price/per night</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Will free</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result as $room)
                            <tr>
                                <td class="text-center">{{ $room->room_number }}</td>
                                <td class="text-center">{{ strtoupper($room->type) }}</td>
                                <td class="text-center">
                                    {{ $room->floor_number }}
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary badge-big">{{ $room->adults_beds_count }}</span>
                                    @if ($room->children_beds_count > 0)
                                    <span class="badge badge-success badge-big"><i class="fa-solid fa-baby"></i></span>
                                    @endif
                                </td>
                                <td class="text-center"><b>{{ $room->price }}</b></td>
                                <td class="text-center">
                                    @if (!isset($room->deleted_at))
                                    @if ($room->status == 'available')
                                    <span class="badge badge-success badge-big">Available</span>
                                    @elseif ($room->status == 'occupied')
                                    <span class="badge badge-danger badge-big">Occupied</span>
                                    @elseif ($room->status == 'under_maintenance')
                                    <span class="badge badge-danger badge-big">Maintenance</span>
                                    @else
                                    <span class="badge badge-secondary badge-big">Unknown</span>
                                    @endif
                                    @else
                                    <span class="badge badge-danger badge-big">Deleted</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (!isset($room->deleted_at))
                                    @if (isset($room->bookings[0]->check_out_date))
                                    @php
                                    $checkOutDate = \Carbon\Carbon::parse(
                                    $room->bookings[0]->check_out_date,
                                    );
                                    $diffInDays = $checkOutDate->diffInDays(\Carbon\Carbon::now());
                                    $formattedDate = $checkOutDate->format('d-m-Y');
                                    @endphp

                                    @if ($diffInDays < 0) <span class="badge badge-success badge-big">Now</span>
                                        @elseif ($diffInDays == 0)
                                        <span class="badge badge-success badge-big">Today</span>
                                        @else
                                        {{ $formattedDate }}
                                        @endif
                                        @else
                                        <span class="badge badge-success badge-big">Now</span>
                                        @endif
                                        @else
                                        <span class="badge badge-danger badge-big">Never</span>
                                        @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Room actions">
                                        @if ($room->status == "available")
                                        @role('admin')
                                        <a href="{{ route('admin.booking.create', $room->id) }}" class="btn btn-success">Book now</a>
                                        @endrole
                                        @role('receptionist')
                                        <a href="{{ route('receptionist.booking.create', $room->id) }}" class="btn btn-success">Book now</a>
                                        @endrole
                                        @endif
                                        @role('admin')
                                        <a href="{{ route('admin.rooms.show', $room->id) }}" class="btn btn-secondary">Details</a>
                                        @endrole
                                        @role('receptionist')
                                        <a href="{{ route('receptionist.rooms.show', $room->id) }}" class="btn btn-secondary">Details</a>
                                        @endrole
                                        @role('admin')
                                        @if (!isset($room->deleted_at))
                                        <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                        <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        @endif
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Main table container end -->
            </div>
            <!-- Inner container end -->
        </div>
        <!-- Content header end -->
    </div>
    <!-- Content container end -->
</div>
<!-- Main container end -->
@endsection
@section('custom-scripts')
@vite(['resources/js/rooms/index.js'])
@endsection