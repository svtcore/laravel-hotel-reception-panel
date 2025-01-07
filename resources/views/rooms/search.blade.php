@extends('layouts.header')
@section('rooms_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/rooms-style.css'])
@endsection
@section('navbar_header_button')
@role('admin')
<a href="{{ route('admin.rooms.create') }}" class="add-new-button">Add room</a>
@endrole
@role('receptionist')
<span class="header-text">Rooms</span>
@endrole
@endsection
@section('content')
<div class="container-fluid">>
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
                    <h4><b>Search form</b></h4>
                    <form id="searchForm" method="POST" action="{{ auth()->user()->hasRole('admin') ? route('admin.rooms.search') : (auth()->user()->hasRole('receptionist') ? route('receptionist.rooms.search') : '#') }}">
                        @csrf
                        <div class="row mt-4">
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
                        <div class="row">
                            <div class="col-md-2 pt-2">
                                <label for="roomNumber"></label>
                                <input type="text" class="form-control text-center @error('roomNumber') is-invalid @enderror" id="roomNumber" name="roomNumber" placeholder="Room number" disabled required maxlength="255" @if (!isset($inputData['roomNumber'])) disabled @else value="{{ $inputData['roomNumber'] }}" @endif>
                            </div>
                            <div class="col-md-4 pt-2">
                                <label for="guestName"></label>
                                <input type="text" class="form-control text-center @error('guestName') is-invalid @enderror" id="guestName" name="guestName" placeholder="Guest name" disabled required maxlength="255" @if (!isset($inputData['guestName'])) disabled @else value="{{ $inputData['guestName'] }}" @endif>
                            </div>
                            <div class="col-md-6 mt-2 @if (!isset($inputData['roomNumber']) || !isset($inputData['roomNumber'])) d-none @endif" id="searchTopBlock">
                                <label for="searchTopBlock"></label>
                                <button type="submit" class="btn btn-primary w-100" name="searchTopBlock" id="searchTopBlock">Search</button>
                            </div>
                        </div>
                        <div id="baseSearch" @if (isset($inputData['roomNumber']) || isset($inputData['roomNumber'])) class="d-none" @endif>
                            <hr />
                            <div class="row">
                                <div class="col-md-3 mb-2 date-block">
                                    <label for="startDate">Start date</label>
                                    <input type="date" class="form-control @error('startDate') is-invalid @enderror" id="startDate" name="startDate" @if (isset($inputData['startDate'])) value="{{ $inputData['startDate'] }}" @else value="{{ \Carbon\Carbon::now()->toDateString() }}" @endif required>
                                </div>
                                <div class="col-md-3 mb-2 date-block">
                                    <label for="endDate">End date</label>
                                    <input type="date" class="form-control @error('endDate') is-invalid @enderror" id="endDate" name="endDate" @if (isset($inputData['endDate'])) value="{{ $inputData['endDate'] }}" @else value="{{ \Carbon\Carbon::now()->toDateString() }}" @endif required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 pt-2">
                                    <label for="type">Type</label>
                                    @php
                                    $options = [
                                    '0' => 'Any',
                                    'standard' => 'Standard',
                                    'deluxe' => 'Deluxe',
                                    'suite' => 'Suite',
                                    'penthouse' => 'Penthouse',
                                    ];
                                    $selectedType = $inputData['type'] ?? null;
                                    @endphp
                                    <select class="form-select text-center @error('type') is-invalid @enderror" id="type" name="type" required>
                                        @foreach ($options as $value => $label)
                                        <option value="{{ $value }}" @if ($selectedType==$value) selected @endif>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 pt-2">
                                    <label for="status">Status</label>
                                    @php
                                    $statusOptions = [
                                    '0' => 'Any',
                                    'available' => 'Available',
                                    'occupied' => 'Occupied',
                                    'under_maintenance' => 'Maintenance',
                                    ];
                                    $selectedStatus = $inputData['status'] ?? null;
                                    @endphp
                                    <select class="form-select text-center @error('status') is-invalid @enderror" id="status" name="status" required>
                                        @foreach ($statusOptions as $value => $label)
                                        <option value="{{ $value }}" @if ($selectedStatus==$value) selected @endif>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 pt-2">
                                    <label for="adultsBedsCount">Adults</label>
                                    @php
                                    $selectedAdults = $inputData['adultsBedsCount'] ?? 0;
                                    @endphp
                                    <select class="form-select text-center @error('adultsBedsCount') is-invalid @enderror" id="adultsBedsCount" name="adultsBedsCount" required>
                                        <option value="0" @if ($selectedAdults==0) selected @endif>Any</option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" @if ($selectedAdults==$i) selected @endif>{{ $i }} person{{ $i > 1 ? 's' : '' }}</option>
                                            @endfor
                                    </select>
                                </div>

                                <div class="col-md-2 pt-2">
                                    <label for="childrenBedsCount">Child bed</label>
                                    @php
                                    $selectedChildren = $inputData['childrenBedsCount'] ?? -1;
                                    @endphp
                                    <select class="form-select text-center @error('childrenBedsCount') is-invalid @enderror" id="childrenBedsCount" name="childrenBedsCount" required>
                                        <option value="-1" @if ($selectedChildren==-1) selected @endif>Any</option>
                                        <option value="0" @if ($selectedChildren==0) selected @endif>No child bed</option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" @if ($selectedChildren==$i) selected @endif>{{ $i }} child bed{{ $i > 1 ? 's' : '' }}</option>
                                            @endfor
                                    </select>
                                </div>

                                <div class="col-md-4 pt-2" id="searchBlock">
                                    <label for="searchButton"></label>
                                    <button type="submit" class="btn btn-primary w-100" name="searchButton" id="searchButton">Search</button>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-12 pt-2">
                                    <div class="border rounded p-3">
                                        <div class="border-bottom pb-2 mb-3">
                                            <button
                                                class="btn btn-outline-secondary w-100 font-weight-bold"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseProperties"
                                                aria-expanded="true"
                                                aria-controls="collapseProperties">
                                                Include additional properties
                                            </button>
                                        </div>
                                        <div class="collapse show" id="collapseProperties">
                                            @foreach ($room_properties as $property)
                                            @php
                                            $isChecked = isset($inputData['additionalProperties']) && in_array($property->id, $inputData['additionalProperties']);
                                            @endphp
                                            <div class="form-check form-check-inline m-3 font-weight-bold">
                                                <input
                                                    class="form-check-input mt-1 mr-2"
                                                    type="checkbox"
                                                    id="property_{{ $property->id }}"
                                                    value="{{ $property->id }}"
                                                    name="additionalProperties[]"
                                                    {{ $isChecked ? 'checked' : '' }}>
                                                <label class="form-check-label" for="property_{{ $property->id }}">
                                                    {{ strtoupper($property->name) }}
                                                </label>
                                            </div>
                                            @endforeach
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
                    <table id="search-results-rooms-table" class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">Room №</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Floor</th>
                                <th class="text-center">Beds</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Will free</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result as $room)
                            <tr>
                                <td class="text-center"><a href="{{ route('admin.rooms.show', $room->id) }}">{{ $room->room_number }}</a></td>
                                <td class="text-center">{{ strtoupper($room->type) }}</td>
                                <td class="text-center">
                                    {{ $room->floor_number }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary badge-big fs-7">{{ $room->adults_beds_count }}</span>
                                    @if ($room->children_beds_count > 0)
                                    <span class="badge bg-success badge-big fs-7"><i class="bi bi-person-arms-up"></i></span>
                                    @endif
                                </td>
                                <td class="text-center"><b>{{ $room->price }}</b></td>
                                <td class="text-center">
                                    @if (!isset($room->deleted_at))
                                    @if ($room->status == 'available')
                                    <span class="badge bg-success badge-big fs-6 pt-2 pb-2 w-100">Available</span>
                                    @elseif ($room->status == 'occupied')
                                    <span class="badge bg-danger badge-big fs-6 pt-2 pb-2 w-100">Occupied</span>
                                    @elseif ($room->status == 'under_maintenance')
                                    <span class="badge bg-danger badge-big fs-6 pt-2 pb-2 w-100">Maintenance</span>
                                    @else
                                    <span class="badge bg-secondary badge-big fs-6 pt-2 pb-2 w-100">Unknown</span>
                                    @endif
                                    @else
                                    <span class="badge bg-danger badge-big fs-6 pt-2 pb-2 w-100">Deleted</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($room->deleted_at === null)
                                    @php
                                    $booking = new \App\Http\Classes\Bookings();
                                    [$free_dates, $last_date] = $booking->getAvailableDate($room->id);
                                    @endphp

                                    @if ($free_dates != null)
                                    @foreach ($free_dates as $date)
                                    <span class="badge bg-success badge-big fs-6 pt-2 pb-2 w-100">
                                        @php
                                        $dates = explode(' — ', $date);
                                        if (count($dates) === 2) {
                                        $start = substr($dates[0], 0, 5);
                                        $end = substr($dates[1], 0, 6);
                                        $formattedDate = $start . ' — ' . $end;
                                        } else {
                                        $formattedDate = $date;
                                        }
                                        @endphp
                                        {{ $formattedDate }}
                                    </span>
                                    <br /><br />
                                    @endforeach
                                    @endif

                                    <span class="badge bg-success badge-big fs-6 pt-2 pb-2 w-100">
                                        @php
                                        $last_date = \Carbon\Carbon::parse($last_date);
                                        @endphp

                                        @if ($last_date === null || $last_date->isPast())
                                        Now
                                        @elseif ($last_date->isToday())
                                        Today
                                        @else
                                        {{ $last_date->format('d.m.Y') }}
                                        @endif
                                    </span>

                                    @endif
                                </td>
                                <td class="text-center" id="rooms_table_action">
                                    <div class="btn-group w-100" role="group" aria-label="Room actions">
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
@vite(['resources/js/rooms/search.js'])
@endsection