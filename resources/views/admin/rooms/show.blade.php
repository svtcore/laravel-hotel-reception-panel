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
            </div>
        </div>

        <div id="main-container">
            <div class="content-container text-center">
                <div class="room-info-table">
                    <h4 class="mb-4"><b>Room Information</b></h4>
                    <div class="row pl-4 pr-4">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Room number
                                    <span class="badge bg-primary badge-big">{{ $room->room_number }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Type
                                    <span class="badge bg-primary badge-big">{{ ucfirst($room->type) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Floor
                                    <span class="badge bg-primary badge-big">{{ $room->floor_number }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total rooms
                                    <span class="badge bg-primary badge-big">{{ $room->total_rooms }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Adults beds
                                    <span class="badge bg-primary badge-big">{{ $room->adults_beds_count }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Children beds
                                    <span class="badge bg-primary badge-big">{{ $room->children_beds_count }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Price per Night
                                    <span class="badge bg-primary badge-big">{{ $room->price }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Current Status
                                    @if ($room->status == 'available')
                                    <span class="badge badge-success badge-big">Available</span>
                                    @elseif ($room->status == 'occupied')
                                    <span class="badge badge-danger badge-big">Occupied</span>
                                    @elseif ($room->status == 'under_maintenance')
                                    <span class="badge badge-secondary badge-big">Maintenance</span>
                                    @else
                                    <span class="badge badge-secondary badge-big">Maintence</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                    @if (count($room->room_properties) > 0)
                    <h5 class="@if (count($room->room_properties) < 3) text-left pl-5 @else text-center @endif mt-4"><b>Additional properties</b></h5>
                    <div class="row pl-4 pr-4 mt-4">
                        @foreach($room->room_properties as $key => $property)
                        @if($key % 2 == 0)
                        <div class="col-md-4">
                            <div class="additional-amenities">
                                <ul class="list-group">
                                    @endif
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="text-center">{{ $property->name }}</span>
                                        <span class="badge badge-success big-badge"><i class="fas fa-check"></i></span>
                                    </li>
                                    @if($key % 2 != 0 || $loop->last)
                                </ul>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            <div class="content-container text-center mt-4 pl-5 pr-5">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="booking-tab" data-bs-toggle="tab" href="#" role="tab" aria-controls="booking" aria-selected="true">
                            Booking History
                            <span class="badge bg-primary">{{ count($booking) }}</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="cleaning-tab" data-bs-toggle="tab" href="#cleaning" role="tab" aria-controls="cleaning" aria-selected="false">
                            Cleaning History
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- First Tab: Booking History Table -->
                    <div class="tab-pane fade show active" id="booking" role="tabpanel" aria-labelledby="booking-tab">
                        <table class="table" id="guests_table">
                            <thead>
                                <tr>
                                    <th>Guest Name</th>
                                    <th>Related persons</th>
                                    <th>Check-in date</th>
                                    <th>Check-out date</th>
                                    <th>Total price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking as $book)
                                <tr>
                                    <?php
                                    $date_check_in = date('d-m-Y', strtotime($book->check_in_date));
                                    $date_check_out = date('d-m-Y', strtotime($book->check_out_date));
                                    ?>
                                    <td>{{ $book->guests[0]->first_name }} {{ $book->guests[0]->last_name }}</td>
                                    <td>{{ count($book->guests) }}</td>
                                    <td>{{ $date_check_in }}</td>
                                    <td>{{ $date_check_out}}</td>
                                    <td>{{ $book->total_cost}}</td>
                                    <td>
                                        @if ($book->status == 'active' || $book->status == 'completed')
                                        <span class="badge badge-success badge-big">{{ $book->status }}</span>
                                        @elseif ($book->status == 'canceled')
                                        <span class="badge badge-danger badge-big">{{ $book->status }}</span>
                                        @else
                                        <span class="badge badge-secondary badge-big">{{ $book->status }}</span>
                                        @endif
                                    </td>
                                    <td><a href="{{ route('admin.booking.show', $book->id) }}" class="btn btn-secondary">Details</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="cleaning" role="tabpanel" aria-labelledby="cleaning-tab">
                        <table class="table" id="cleaning_table">
                            <thead>
                                <tr>
                                    <th>Cleaning Date</th>
                                    <th>Staff Name</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cleaning as $clean)
                                <tr>
                                    <td>{{ date('d-m-Y [H:i]', strtotime($clean->datetime)) }}</td>
                                    <td>{{ $clean->staff->first_name }} {{ $clean->staff->last_name }}</td>
                                    <td>{{ $clean->note }}</td>
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
@endsection

@section('custom-scripts')
@vite(['resources/js/rooms/show.js'])
@endsection