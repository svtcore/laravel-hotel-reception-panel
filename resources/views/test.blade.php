@extends('layouts.header')
@section('dashboard_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/bookings-style.css'])
@endsection
@section('content')
    <!-- Main content -->
    <div class="container-fluid mt-3">

        <div class="content-container">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="content-container text-center">
                        <h4>Search Orders</h4>

                        <!-- Форма для поиска -->
                        <form id="searchForm">
                            <div class="row mt-5">
                                <div class="col-md-4">
                                    <label class="toggle">
                                        <input class="toggle-checkbox" id="switch-by-date" type="checkbox">
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">By date</span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="toggle" checked>
                                        <input class="toggle-checkbox" id="switch-by-name" type="checkbox">
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">By guest name</span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="toggle">
                                        <input class="toggle-checkbox" id="switch-by-phone" type="checkbox">
                                        <div class="toggle-switch"></div>
                                        <span class="toggle-label">By phone</span>
                                    </label>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-2 mb-2 date-block">
                                    <label for="startDate">Start date</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate" disabled
                                        required>
                                </div>
                                <div class="col-md-2 mb-2 date-block">
                                    <label for="endDate">End date</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate" disabled
                                        required>
                                </div>
                                <div class="col-md-3 pt-2">
                                    <label for="guestName"></label>
                                    <input type="text" class="form-control" id="guestName" name="guestName"
                                        placeholder="Full name" required>
                                </div>
                                <div class="col-md-2 pt-2">
                                    <label for="phoneNumber"></label>
                                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber"
                                        placeholder="Phone number" disabled required>
                                </div>
                                <div class="col-md-3 pt-2">
                                    <label for="phoneNumber"></label>
                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="searchOrders()">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="mt-3">
                        <label>Last 50 bookings</label>
                    </div>
                    <div id="chat-container">
                        <table id="check-in-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Room №</th>
                                    <th>Guest name</th>
                                    <th>Persons</th>
                                    <th>Phone number</th>
                                    <th>Price</th>
                                    <th>Check-In</th>
                                    <th>Check-Out</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#">#123</a></td>
                                    <td>John Doe</td>
                                    <td>2</td>
                                    <td>380921122333</td>
                                    <td>1700</td>
                                    <td>2024-02-01</td>
                                    <td>2024-02-07</td>
                                    <td class="text-center">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button type="button" class="btn btn-secondary"><i
                                                    class="fas fa-address-card"></i></button>
                                            <button type="button" class="btn btn-secondary"><i
                                                    class="fas fa-pen"></i></button>
                                            <button type="button" class="btn btn-secondary"><i
                                                    class="fas fa-ban"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="#">#123</a></td>
                                    <td>John Green</td>
                                    <td>2</td>
                                    <td>380921122333</td>
                                    <td>1250</td>
                                    <td>2024-02-01</td>
                                    <td>2024-02-07</td>
                                    <td class="text-center">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button type="button" class="btn btn-secondary"><i
                                                    class="fas fa-address-card"></i></button>
                                            <button type="button" class="btn btn-secondary"><i
                                                    class="fas fa-pen"></i></button>
                                            <button type="button" class="btn btn-secondary"><i
                                                    class="fas fa-ban"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Здесь может быть ваш контент с результатами поиска -->
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- /.content -->
@section('custom-scripts')
@vite(['resources/js/bookings/index.js'])
@endsection
@endsection
