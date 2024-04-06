@extends('layouts.header')
@section('rooms_navbar_state', 'active')
@section('additional_style')
    @vite(['resources/css/rooms-style.css'])
@endsection
@section('content')
    <div class="container-fluid mt-3">
        <div class="content-container">
            <div class="content-header">
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
                    <div class="content-container text-center">
                        <h4>Search form</h4>

                        <form id="searchForm" method="POST" action="{{ route('admin.rooms.search') }}">
                            @csrf
                            <div class="row mt-4">
                                <div class="col-md-2">
                                    <label class="toggle">
                                        <input class="toggle-checkbox" id="switch-by-number" type="checkbox"
                                            @if (isset($inputData['roomNumber'])) checked @endif>
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">By number</span>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="toggle">
                                        <input class="toggle-checkbox" id="switch-by-guest" type="checkbox"
                                            @if (isset($inputData['guestName'])) checked @endif>
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">By guest name</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-2 pt-2">
                                    <label for="roomNumber"></label>
                                    <input type="text" class="form-control text-center" id="roomNumber" name="roomNumber"
                                        placeholder="Room number"
                                        @if (!isset($inputData['roomNumber'])) disabled @else value="{{ $inputData['roomNumber'] }}" @endif
                                        required>
                                </div>
                                <div class="col-md-4 pt-2">
                                    <label for="guestName"></label>
                                    <input type="text" class="form-control text-center" id="guestName" name="guestName"
                                        placeholder="Guest name"
                                        @if (!isset($inputData['guestName'])) disabled @else value="{{ $inputData['guestName'] }}" @endif
                                        required>
                                </div>
                                <div class="col-md-6 mt-2 @if (!isset($inputData['roomNumber']) || !isset($inputData['roomNumber'])) d-none @endif "
                                    id="searchTopBlock">
                                    <label for="searchTopBlock"></label>
                                    <button type="submit" class="btn btn-primary w-100" name="searchTopBlock"
                                        id="searchTopBlock">Search</button>
                                </div>
                            </div>
                            <div id="baseSearch" @if (isset($inputData['roomNumber']) || isset($inputData['roomNumber'])) class="d-none" @endif>
                                <hr />
                                <div class="form-row">
                                    <div class="col-md-2 mb-2 date-block">
                                        <label for="startDate">Start date</label>
                                        <input type="date" class="form-control" id="startDate" name="startDate"
                                            @if (isset($inputData['startDate'])) value="{{ $inputData['startDate'] }}" @else value="{{ \Carbon\Carbon::now()->toDateString() }}" @endif
                                            required>
                                    </div>
                                    <div class="col-md-2 mb-2 date-block">
                                        <label for="endDate">End date</label>
                                        <input type="date" class="form-control" id="endDate" name="endDate"
                                            @if (isset($inputData['endDate'])) value="{{ $inputData['endDate'] }}" @else value="{{ \Carbon\Carbon::now()->toDateString() }}" @endif
                                            required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2 pt-2">
                                        <label for="roomType">Type</label>
                                        <select class="form-select text-center" id="roomType" name="roomType" required>
                                            <option value="0" @if (isset($inputData['roomType']) && $inputData['roomType'] == 0) selected @endif>Any
                                            </option>
                                            <option value="standart" @if (isset($inputData['roomType']) && $inputData['roomType'] == 'standart') selected @endif>
                                                Standart</option>
                                            <option value="comfort" @if (isset($inputData['roomType']) && $inputData['roomType'] == 'comfort') selected @endif>
                                                Comfort</option>
                                            <option value="premium" @if (isset($inputData['roomType']) && $inputData['roomType'] == 'premium') selected @endif>
                                                Premium</option>
                                            <option value="king" @if (isset($inputData['roomType']) && $inputData['roomType'] == 'king') selected @endif>King
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <label for="roomStatus">Status</label>
                                        <select class="form-select text-center" id="roomStatus" name="roomStatus" required>
                                            <option value="0" @if (isset($inputData['roomStatus']) && $inputData['roomStatus'] == 0) ) selected @endif>Any
                                            </option>
                                            <option value="free" @if (isset($inputData['roomStatus']) && $inputData['roomStatus'] == 'free') ) selected @endif>
                                                Free</option>
                                            <option value="busy" @if (isset($inputData['roomStatus']) && $inputData['roomStatus'] == 'busy') ) selected @endif>
                                                Busy</option>
                                            <option value="maintence" @if (isset($inputData['roomStatus']) && $inputData['roomStatus'] == 'maintence') ) selected @endif>
                                                Maintence</option>
                                            <option value="reserved" @if (isset($inputData['roomStatus']) && $inputData['roomStatus'] == 'reserved') ) selected @endif>
                                                Reserved</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <label for="roomAdult">Adults</label>
                                        <select class="form-select text-center" id="roomAdult" name="roomAdult" required>
                                            <option value="0" @if (isset($inputData['roomAdult']) && $inputData['roomAdult'] == 0) selected @endif>Any
                                            </option>
                                            <option value="1" @if (isset($inputData['roomAdult']) && $inputData['roomAdult'] == 1) selected @endif>1
                                                person</option>
                                            <option value="2" @if (isset($inputData['roomAdult']) && $inputData['roomAdult'] == 2) selected @endif>2
                                                persons</option>
                                            <option value="3" @if (isset($inputData['roomAdult']) && $inputData['roomAdult'] == 3) selected @endif>3
                                                persons</option>
                                            <option value="4" @if (isset($inputData['roomAdult']) && $inputData['roomAdult'] == 4) selected @endif>4
                                                persons</option>
                                            <option value="5" @if (isset($inputData['roomAdult']) && $inputData['roomAdult'] == 5) selected @endif>5
                                                persons</option>
                                            <option value="6" @if (isset($inputData['roomAdult']) && $inputData['roomAdult'] == 6) selected @endif>6
                                                persons</option>
                                            <option value="7" @if (isset($inputData['roomAdult']) && $inputData['roomAdult'] == 7) selected @endif>7
                                                persons</option>
                                            <option value="8" @if (isset($inputData['roomAdult']) && $inputData['roomAdult'] == 8) selected @endif>8
                                                persons</option>
                                            <option value="9" @if (isset($inputData['roomAdult']) && $inputData['roomAdult'] == 9) selected @endif>9
                                                persons</option>
                                            <option value="10" @if (isset($inputData['roomAdult']) && $inputData['roomAdult'] == 10) selected @endif>10
                                                persons</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <label for="roomChildren">Child bed</label>
                                        <select class="form-select text-center" id="roomChildren" name="roomChildren"
                                            required>
                                            <option value="-1" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == -1) selected @endif>Any
                                            </option>
                                            <option value="0" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == 0) selected @endif>NO
                                                CHILD BED</option>
                                            <option value="1" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == 1) selected @endif>1
                                                child bed</option>
                                            <option value="2" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == 2) selected @endif>2
                                                child bed</option>
                                            <option value="3" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == 3) selected @endif>3
                                                child bed</option>
                                            <option value="4" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == 4) selected @endif>4
                                                child bed</option>
                                            <option value="5" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == 5) selected @endif>5
                                                child bed</option>
                                            <option value="6" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == 6) selected @endif>6
                                                child bed</option>
                                            <option value="7" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == 7) selected @endif>7
                                                child bed</option>
                                            <option value="8" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == 8) selected @endif>8
                                                child bed</option>
                                            <option value="9" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == 9) selected @endif>9
                                                child bed</option>
                                            <option value="10" @if (isset($inputData['roomChildren']) && $inputData['roomChildren'] == 10) selected @endif>10
                                                child bed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 pt-3" id="searchBlock">
                                        <label for="searchButton"></label>
                                        <button type="submit" class="btn btn-primary w-100" name="searchButton"
                                            id="searchButton">Search</button>
                                    </div>
                                </div>
                                <div class="form-row mt-1">
                                    <div class="col-md-12 pt-2">
                                        <div class="border rounded p-3">
                                            <div class="border-bottom pb-2 mb-3">
                                                <h6 class="mb-0">Room properties</h6>
                                            </div>
                                            @foreach ($room_properties as $property)
                                                <div class="form-check form-check-inline m-3 font-weight-bold">
                                                    <input class="form-check-input mt-1 mr-2" type="checkbox"
                                                        id="property_{{ $property->id }}" value="{{ $property->id }}"
                                                        name="properties[]"
                                                        @if (isset($inputData['properties'])) @foreach ($inputData['properties'] as $prop)
                                                                @if ($property->id == $prop) checked @endif
                                                        @endforeach
                                            @endif>
                                            <label class="form-check-label"
                                                for="property_{{ $property->id }}">{{ strtoupper($property->name) }}</label>
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
                                    <td class="text-center">{{ $room->door_number }}</td>
                                    <td class="text-center">{{ strtoupper($room->type) }}</td>
                                    <td class="text-center">
                                        {{ $room->floor }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-primary badge-big">{{ $room->bed_amount }}</span>
                                        @if ($room->children_bed_amount > 0)
                                            <span class="badge badge-success badge-big"><i class="fa-solid fa-baby"></i></span> 
                                        @endif
                                    </td>
                                    <td class="text-center"><b>{{ $room->price }} ₴</b></td>
                                    <td class="text-center">
                                        @if ($room->status == 'free')
                                            <span class="badge badge-success badge-big">Free</span>
                                        @elseif ($room->status == 'busy')
                                            <span class="badge badge-danger badge-big">Busy</span>
                                        @elseif ($room->status == 'reserved')
                                            <span class="badge badge-secondary badge-big">Reserved</span>
                                        @else
                                            <span class="badge badge-secondary badge-big">Maintence</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (isset($room->bookings[0]->check_out_date))
                                            @php
                                                $checkOutDate = \Carbon\Carbon::parse(
                                                    $room->bookings[0]->check_out_date,
                                                );
                                                $diffInDays = $checkOutDate->diffInDays(\Carbon\Carbon::now());
                                                $formattedDate = $checkOutDate->format('d-m-Y');
                                            @endphp

                                            @if ($diffInDays < 0)
                                                <span class="badge badge-success badge-big">Now</span>
                                            @elseif ($diffInDays == 0)
                                                <span class="badge badge-success badge-big">Today</span>
                                            @else
                                                {{ $formattedDate }}
                                            @endif
                                        @else
                                            <span class="badge badge-success badge-big">Now</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Room actions">
                                            <a href="{{ route('admin.rooms.show', $room->id) }}" class="btn btn-primary">Details</a>
                                            <button type="button" class="btn btn-warning">Edit</button>
                                            <button type="button" class="btn btn-danger">Delete</button>
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
    </div>
    </div>
    @section('custom-scripts')
        @vite(['resources/js/rooms/index.js'])
    @endsection
@endsection
