@extends('layouts.header')
@section('guests_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/guests-style.css'])
@endsection
@section('navbar_header_button')
@role('admin')
<a href="{{ route('admin.guests.create') }}" style="width:400px;" class="add-new-button">Add Guest</a>
@endrole
@role('receptionist')
<a href="{{ route('receptionist.guests.create') }}" style="width:400px;" class="add-new-button">Add Guest</a>
@endrole
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="content-container">
        <div class="content-header">
            <div class="container-fluid">
                <!-- Display success message if any -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <!-- Display error messages if any -->
                @if ($errors->any())
                <div class="alert alert-danger w-100">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div id="main-container">
                    <div class="content-container text-center">
                        <div class="room-info-table">
                            <h4 class="mb-4"><b>Guest data</b></h4>

                            <div class="row pl-4 pr-4">
                                <!-- Guest information -->
                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Full name
                                            <!-- Display guest's full name -->
                                            <span class="badge bg-secondary badge-big">{{ $guest->first_name }} {{ $guest->last_name }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Gender
                                            <!-- Display guest's gender -->
                                            <span class="badge bg-secondary badge-big">
                                                @if ($guest->gender == "M") Male
                                                @elseif ($guest->gender == "F") Female
                                                @else Other
                                                @endif
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Date of Birthday
                                            <!-- Display guest's date of birth -->
                                            <span class="badge bg-secondary badge-big">{{ $guest->dob }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Phone number
                                            <!-- Display guest's phone number -->
                                            <span class="badge bg-secondary badge-big">{{ $guest->phone_number }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Guest document information -->
                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Doc. country
                                            <!-- Display guest's document country -->
                                            <span class="badge bg-secondary badge-big">@isset($guest->guest_document->document_country) {{ $guest->guest_document->document_country }} @endisset</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Doc. serial
                                            <!-- Display guest's document serial -->
                                            <span class="badge bg-secondary badge-big">@isset($guest->guest_document->document_serial) {{ $guest->guest_document->document_serial }} @endisset</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Doc. number
                                            <!-- Display guest's document number -->
                                            <span class="badge bg-secondary badge-big">@isset($guest->guest_document->document_number) {{ $guest->guest_document->document_number }} @endisset</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Doc. expired
                                            <!-- Display guest's document expiry date -->
                                            <span class="badge bg-secondary badge-big">@isset($guest->guest_document->document_expired) {{ $guest->guest_document->document_expired }} @endisset</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Doc. issued date
                                            <!-- Display guest's document issued date -->
                                            <span class="badge bg-secondary badge-big">@isset($guest->guest_document->document_issued_date) {{ $guest->guest_document->document_issued_date }} @endisset</span>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex flex-column">
                                                <span class="label mb-1 text-left">Doc. issued by:</span>
                                                <!-- Display guest's document issued by -->
                                                <span class="text-left">@isset($guest->guest_document->document_issued_by) {{ $guest->guest_document->document_issued_by }} @endisset</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Control panel for admin or receptionist -->
                                <div class="col-md-4">
                                    <div class="card no-shadow">
                                        <div class="card-body">
                                            <h5 class="mb-2"><b>Control panel</b></h5>
                                            <ul class="list-group">
                                                <!-- Button to edit guest data -->
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    @role('admin')
                                                    <a href="{{ route('admin.guests.edit', $guest->id) }}" class="btn btn-primary w-100">Edit data</a>
                                                    @endrole
                                                    @role('receptionist')
                                                    <a href="{{ route('receptionist.guests.edit', $guest->id) }}" class="btn btn-primary w-100">Edit data</a>
                                                    @endrole
                                                </li>
                                                <!-- Form to delete guest -->
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    @role('admin')
                                                    <form action="{{ route('admin.guests.delete', $guest->id) }}" method="POST" class="w-100">
                                                    @endrole
                                                    @role('receptionist')
                                                    <form action="{{ route('receptionist.guests.delete', $guest->id) }}" method="POST" class="w-100">
                                                    @endrole     
                                                    @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger w-100" type="submit">Delete</button>
                                                    </form>
                                                    
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table to display guest bookings -->
                <div class="content-container text-center mt-4 pl-5 pr-5">
                    <table class="table" id="guests_table">
                        <thead>
                            <tr>
                                <th class="text-center">Check-in date</th>
                                <th class="text-center">Check-out date</th>
                                <th class="text-center">Total price</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through guest bookings -->
                            @foreach($bookings as $book)
                            <tr>
                                @php
                                // Format check-in and check-out dates
                                $date_check_in = date('d-m-Y', strtotime($book->check_in_date));
                                $date_check_out = date('d-m-Y', strtotime($book->check_out_date));
                                @endphp
                                <!-- Display booking information -->
                                <td class="text-center">{{ $date_check_in }}</td>
                                <td class="text-center">{{ $date_check_out}}</td>
                                <td class="text-center">{{ $book->total_cost}}</td>
                                <td class="text-center">
                                    <!-- Display booking status -->
                                    @if ($book->status == 'active' || $book->status == 'completed')
                                    <span class="badge badge-success badge-big">{{ $book->status }}</span>
                                    @elseif ($book->status == 'canceled')
                                    <span class="badge badge-danger badge-big">{{ $book->status }}</span>
                                    @else
                                    <span class="badge badge-secondary badge-big">{{ $book->status }}</span>
                                    @endif
                                </td>
                                <!-- Button to view booking details -->
                                @role('admin')
                                <td class="text-center"><a href="{{ route('admin.booking.show', $book->id) }}" class="btn btn-secondary pt-0 pb-0 pr-4 pl-4">Details</a></td>
                                @endrole
                                @role('receptionist')
                                <td class="text-center"><a href="{{ route('receptionist.booking.show', $book->id) }}" class="btn btn-secondary pt-0 pb-0 pr-4 pl-4">Details</a></td>
                                @endrole
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
@vite(['resources/js/rooms/show.js'])
@endsection