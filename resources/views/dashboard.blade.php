@extends('layouts.header')
@section('dashboard_navbar_state', 'active')
@section('additional_style')
@endsection
@section('navbar_header_button')
<h5 class="header-navbar ml-5 mt-1 mb-1 p-0">Statistics</h5>
@endsection

@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <div class="content-header">
            <!-- Display success message if exists -->
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <!-- Display error messages if any -->
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
                <div class="col-lg-6">
                    <div class="card no-shadow">
                        <div class="card-header stat-header text-white pl-3 pt-2 pb-2 font-weight-bold d-flex align-items-center justify-content-center">
                            <h3 class="card-title mb-0">Income for current month</h3>
                        </div>
                        <div class="card-body">
                            <!-- Hidden textarea for sum by day -->
                            <textarea style="display:none;" id="sum_by_day" name="sum_by_day">{{ $sum_by_day }}</textarea>
                            <!-- Chart canvas for income line chart -->
                            <canvas id="lineChart"></canvas>
                        </div>
                        <!-- Total income section -->
                        <div class="total-income stat-header text-white pl-3 pt-2 pb-2 font-weight-bold" id="total_income">
                        </div>
                        <!-- Today's income section -->
                        <div class="today-income stat-header text-white pl-3 pt-2 pb-2 font-weight-bold" id="today_income">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card no-shadow">
                        <div class="card-header stat-header text-white pl-3 pt-2 pb-2 font-weight-bold d-flex align-items-center justify-content-center">
                            <h3 class="card-title mb-0">Bookings for current month</h3>
                        </div>
                        <div class="card-body">
                            <!-- Hidden textarea for bookings by day -->
                            <textarea style="display:none;" id="bookings_by_day" name="bookings_by_day">{{ $bookings_by_day }}</textarea>
                            <!-- Chart canvas for bookings line chart -->
                            <canvas id="lineChartBookings"></canvas>
                        </div>
                        <!-- Total bookings section -->
                        <div class="total-bookings stat-header text-white pl-3 pt-2 pb-2 font-weight-bold" id="total_bookings">
                        </div>
                        <!-- Today's bookings section -->
                        <div class="today-bookings stat-header text-white pl-3 pt-2 pb-2 font-weight-bold" id="today_bookings">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card no-shadow">
                        <div class="card-header stat-header text-white pl-3 pt-2 pb-2 font-weight-bold d-flex align-items-center justify-content-center">
                            <h3 class="card-title mb-0">Rooms availability</h3>
                        </div>
                        <div class="card-body mx-auto">
                            <!-- Hidden textarea for rooms availability data -->
                            <textarea style="display:none;" id="rooms_availability_data" name="rooms_availability_data">{{ $rooms_availability_data }}</textarea>
                            <!-- Chart canvas for rooms availability line chart -->
                            <canvas id="lineChartAvailability"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card no-shadow">
                        <div class="card-header stat-header text-white pl-3 pt-2 pb-2 font-weight-bold d-flex align-items-center justify-content-center">
                            <h3 class="card-title mb-0">Room type statistics</h3>
                        </div>
                        <div class="card-body mx-auto">
                            <!-- Hidden textarea for room data -->
                            <textarea style="display:none;" id="room_data" name="room_data">{{ $room_data }}</textarea>
                            <!-- Chart canvas for room sales chart -->
                            <canvas id="roomSalesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@vite(['resources/js/dashboard/income.js'])
@vite(['resources/js/dashboard/rooms.js'])
@vite(['resources/js/dashboard/rooms_availability.js'])
@vite(['resources/js/dashboard/bookings.js'])
@endsection