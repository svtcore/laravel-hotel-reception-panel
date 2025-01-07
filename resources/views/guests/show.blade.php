@extends('layouts.header')
@section('title', 'Guest information')
@section('guests_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/guests-style.css'])
@endsection
@section('navbar_header_button')
<a href="{{ auth()->user()->hasRole('admin') ? route('admin.guests.create') : route('receptionist.guests.create') }}" class="add-new-button">Add guest</a>
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
                <div id="main-container">
                    <div class="content-container text-center">
                        <div class="room-info-table">
                            <h4 class="mb-4"><b>Guest information</b></h4>
                            <div class="row pl-4 pr-4">
                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Full name:
                                            <span class="badge bg-secondary badge-big fs-7">{{ $guest->first_name }} {{ $guest->last_name }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Gender:
                                            <span class="badge bg-secondary badge-big fs-7">
                                                @if ($guest->gender == "M") Male
                                                @elseif ($guest->gender == "F") Female
                                                @else Other
                                                @endif
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Date of Birthday:
                                            <span class="badge bg-secondary badge-big fs-7">{{ \Carbon\Carbon::parse($guest->dob)->format('d-m-Y') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Phone number:
                                            <span class="badge bg-secondary badge-big fs-7">{{ $guest->phone_number }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Doc. country:
                                            <span class="badge bg-secondary badge-big fs-7">@isset($guest->guest_document->document_country) {{ $guest->guest_document->document_country }} @endisset</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Doc. serial:
                                            <span class="badge bg-secondary badge-big fs-7">@isset($guest->guest_document->document_serial) {{ $guest->guest_document->document_serial }} @endisset</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Doc. number:
                                            <span class="badge bg-secondary badge-big fs-7">@isset($guest->guest_document->document_number) {{ $guest->guest_document->document_number }} @endisset</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Doc. expired:
                                            <span class="badge bg-secondary badge-big fs-7">@isset($guest->guest_document->document_expired) {{ \Carbon\Carbon::parse($guest->guest_document->document_expired)->format('d-m-Y') }} @endisset</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Doc. issued date:
                                            <span class="badge bg-secondary badge-big fs-7">@isset($guest->guest_document->document_issued_date) {{ \Carbon\Carbon::parse($guest->guest_document->document_issued_date)->format('d-m-Y') }} @endisset</span>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex flex-column">
                                                <span class="label mb-1 text-left">Doc. issued by:</span>
                                                <span class="text-left">@isset($guest->guest_document->document_issued_by) {{ $guest->guest_document->document_issued_by }} @endisset</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <div class="card no-shadow">
                                        <div class="card-body">
                                            <h5 class="mb-2"><b>Control panel</b></h5>
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a href="{{ auth()->user()->hasRole('admin') ? route('admin.guests.edit', $guest->id) : (auth()->user()->hasRole('receptionist') ? route('receptionist.guests.edit', $guest->id) : '#') }}" class="btn btn-warning w-100">Edit data</a>
                                                </li>
                                                @role('admin')
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <form action="{{ route('admin.guests.delete', $guest->id) }}" method="POST" class="w-100">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger w-100" type="submit">Delete</button>
                                                    </form>
                                                </li>
                                                @endrole
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-container text-center mt-4 pl-5 pr-5">
                    <table class="table" id="guests_table">
                        <thead>
                            <tr>
                                <th class="text-center">Room №</th>
                                <th class="text-center">Check-in date</th>
                                <th class="text-center">Check-out date</th>
                                <th class="text-center">Days</th>
                                <th class="text-center">Total price</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $book)
                            <tr>
                                @php
                                $date_check_in = date('d-m-Y', strtotime($book->check_in_date));
                                $date_check_out = date('d-m-Y', strtotime($book->check_out_date));
                                @endphp
                                <td class="text-center"><a href="{{ route(Auth::user()->hasRole('admin') ? 'admin.rooms.show' : (auth()->user()->hasRole('receptionist') ? 'receptionist.rooms.show' : '#'), $book->room_id) }}">{{ $book->rooms->room_number }}</a></td>
                                <td class="text-center">{{ $date_check_in }}</td>
                                <td class="text-center">{{ $date_check_out }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($book->check_out_date)->diffInDays(\Carbon\Carbon::parse($book->check_in_date), true) }}</td>
                                <td class="text-center">{{ $book->total_cost }}</td>
                                <td class="text-center">
                                    @if ($book->status == 'active' || $book->status == 'completed')
                                    <span class="badge bg-success fs-6 pt-2 pb-2 w-100 badge-big">{{ $book->status }}</span>
                                    @elseif ($book->status == 'canceled')
                                    <span class="badge bg-danger fs-6 pt-2 pb-2 w-100 badge-big">{{ $book->status }}</span>
                                    @else
                                    <span class="badge bg-secondary fs-6 pt-2 pb-2 w-100 badge-big">{{ $book->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.booking.show' : (auth()->user()->hasRole('receptionist') ? 'receptionist.booking.show' : '#'), $book->id) }}"
                                        class="btn btn-secondary">Details</a>
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
@vite(['resources/js/guests/show.js'])
@endsection