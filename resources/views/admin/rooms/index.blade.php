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
                            <div class="form-row">
                                <div class="col-md-2 pt-2">
                                    <label for="roomNumber"></label>
                                    <input type="text" class="form-control text-center" id="roomNumber" name="roomNumber"
                                        placeholder="Room number" disabled required>
                                </div>
                                <div class="col-md-4 pt-2">
                                    <label for="guestName"></label>
                                    <input type="text" class="form-control text-center" id="guestName" name="guestName"
                                        placeholder="Guest name" disabled required>
                                </div>
                                <div class="col-md-6 mt-2 d-none" id="searchTopBlock">
                                    <label for="searchTopBlock"></label>
                                    <button type="submit" class="btn btn-primary w-100" name="searchTopBlock"
                                        id="searchTopBlock">Search</button>
                                </div>
                            </div>
                            <div id="baseSearch">
                                <hr />
                                <div class="form-row">
                                    <div class="col-md-2 mb-2 date-block">
                                        <label for="startDate">Start date</label>
                                        <input type="date" class="form-control" id="startDate" name="startDate"
                                            value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                    </div>
                                    <div class="col-md-2 mb-2 date-block">
                                        <label for="endDate">End date</label>
                                        <input type="date" class="form-control" id="endDate" name="endDate"
                                            value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2 pt-2">
                                        <label for="roomType">Type</label>
                                        <select class="form-select text-center" id="roomType" name="roomType" required>
                                            <option value="0">Any</option>
                                            <option value="standart">Standart</option>
                                            <option value="comfort">Comfort</option>
                                            <option value="premium">Premium</option>
                                            <option value="king">King</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <label for="roomStatus">Status</label>
                                        <select class="form-select text-center" id="roomStatus" name="roomStatus" required>
                                            <option value="0">Any</option>
                                            <option value="free">Free</option>
                                            <option value="busy">Busy</option>
                                            <option value="maintence">Maintence</option>
                                            <option value="reserved">Reserved</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <label for="roomAdult">Adults</label>
                                        <select class="form-select text-center" id="roomAdult" name="roomAdult" required>
                                            <option value="0" selected>Any</option>
                                            <option value="1">1 person</option>
                                            <option value="2">2 persons</option>
                                            <option value="3">3 persons</option>
                                            <option value="4">4 persons</option>
                                            <option value="5">5 persons</option>
                                            <option value="6">6 persons</option>
                                            <option value="7">7 persons</option>
                                            <option value="8">8 persons</option>
                                            <option value="9">9 persons</option>
                                            <option value="10">10 persons</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <label for="roomChildren">Child bed</label>
                                        <select class="form-select text-center" id="roomChildren" name="roomChildren"
                                            required>
                                            <option value="-1" selected>Any</option>
                                            <option value="0">NO CHILD BED</option>
                                            <option value="1">1 child bed</option>
                                            <option value="2">2 child bed</option>
                                            <option value="3">3 child bed</option>
                                            <option value="4">4 child bed</option>
                                            <option value="5">5 child bed</option>
                                            <option value="6">6 child bed</option>
                                            <option value="7">7 child bed</option>
                                            <option value="8">8 child bed</option>
                                            <option value="9">9 child bed</option>
                                            <option value="10">10 child bed</option>
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
                                                        name="properties[]">
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
                        <h4><b>Avaliable rooms</b></h4>
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
