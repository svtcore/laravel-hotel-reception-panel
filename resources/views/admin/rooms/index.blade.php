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
                                <div class="col-md-6 mt-2" id="searchTopBlock">
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
                                        <label for="roomType"></label>
                                        <select class="form-select text-center" id="roomType" name="roomType" required>
                                            <option value="standart" selected>Standart</option>
                                            <option value="comfort">Comfort</option>
                                            <option value="premium">Premium</option>
                                            <option value="king">King</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <label for="roomStatus"></label>
                                        <select class="form-select text-center" id="roomStatus" name="roomStatus" required>
                                            <option value="free" selected>Free</option>
                                            <option value="busy">Busy</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <label for="roomAdult"></label>
                                        <select class="form-select text-center" id="roomAdult" name="roomAdult" required>
                                            <option value="1" selected>1 person</option>
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
                                        <label for="roomChildren"></label>
                                        <select class="form-select text-center" id="roomChildren" name="roomChildren"
                                            required>
                                            <option value="0" selected>NO CHILD BED</option>
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
                                    <div class="col-md-4 pt-2" id="searchBlock">
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
                    <div id="chat-container">
                        <table id="free-rooms-table" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-center">Room №</th>
                                    <th>Type</th>
                                    <th>Floor</th>
                                    <th>Rooms</th>
                                    <th>Beds(A)</th>
                                    <th>Beds(C)</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rooms as $room)
                                    <tr>
                                        <td class="text-center">{{ $room->door_number }}</td>
                                        <td class="text-center">{{ strtoupper($room->type) }}</td>
                                        <td class="text-center font-weight-bold">{{ $room->floor }}</td>
                                        <td class="text-center font-weight-bold">{{ $room->room_amount }}</td>
                                        <td class="text-center font-weight-bold">{{ $room->bed_amount }}</td>
                                        <td class="text-center font-weight-bold">{{ $room->children_bed_amount }}</td>
                                        <td class="text-center">{{ $room->price }}</td>
                                        <td class="text-center">
                                            <form action="#" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <input type="hidden" value="#" name="status" />
                                                    <button type="submit" class="btn btn-success">Book room</button>
                                                    <input type="hidden" value="#" name="status" />
                                                    <button type="submit" class="btn btn-warning"><i
                                                            class="fas fa-pen"></i></button>
                                                    <a href="#" type="submit" class="btn btn-danger"><i
                                                            class="fas fa-ban"></i></a>
                                                </div>
                                            </form>
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
