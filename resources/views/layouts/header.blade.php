<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.min.css">

    <!-- DataTables Responsive extension CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css">

    <!-- DataTables Buttons extension CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.bootstrap5.min.css">

    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Your custom styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/main-style.css'])
    @yield('additional_style')
    <style>
        .user-profile {
            border: 1px solid white;
            border-radius: 5px;
        }

        .user-profile p {
            font-size: 16px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-primary fixed-top">
            <div class="container-fluid">
                <ul class="navbar-nav mx-auto mt-1 pb-0">
                    <li class="nav-item w-100">
                        @yield('navbar_header_button')
                    </li>
                    @yield('navbar_header_button_second')
                </ul>
                <ul class="navbar-nav mr-4">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm" style="background-color: white; color:black;"><i class="fas fa-sign-out-alt"></i></button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary">
            <!-- Brand Logo -->
            <a href="#" class="brand-link d-block text-center">
                <span class="brand-text font-weight-light">Hotel Booking</span>
            </a>

            <!-- Book Button -->
            <!--<button href="#" class="book-button">Book a room</button>!-->

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link nav-custom @yield('dashboard_navbar_state')">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @endrole
                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.rooms.index') }}" class="nav-link nav-custom @yield('rooms_navbar_state')">
                                <i class="nav-icon fas fa-bed"></i>
                                <p>Rooms</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.services.index') }}" class="nav-link nav-custom @yield('services_navbar_state')">
                                <i class="nav-icon fas fa-bed"></i>
                                <p>Additional Services</p>
                            </a>
                        </li>
                        @endrole
                        @role('receptionist')
                        <li class="nav-item">
                            <a href="{{ route('receptionist.rooms.index') }}" class="nav-link nav-custom @yield('rooms_navbar_state')">
                                <i class="nav-icon fas fa-bed"></i>
                                <p>Rooms</p>
                            </a>
                        </li>
                        @endrole
                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.booking.index') }}" class="nav-link nav-custom @yield('booking_navbar_state')">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Booking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.guests.index') }}" class="nav-link nav-custom @yield('guests_navbar_state')">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>Guests</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.employees.index') }}" class="nav-link nav-custom @yield('employees_navbar_state')">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                        @endrole
                        @role('receptionist')
                        <li class="nav-item">
                            <a href="{{ route('receptionist.booking.index') }}" class="nav-link nav-custom @yield('booking_navbar_state')">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Booking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('receptionist.guests.index') }}" class="nav-link nav-custom @yield('guests_navbar_state')">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>Guests</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('receptionist.employees.index') }}" class="nav-link nav-custom @yield('employees_navbar_state')">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                        @endrole
                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link nav-custom @yield('users_navbar_state')">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        @endrole
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
    <!-- Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Version 1.0
        </div>
    </footer>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- AdminLTE JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.min.js"></script>


    <!-- Bootstrap JS (required for DataTables with Bootstrap) -->
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.bootstrap5.min.js"></script>

    <!-- Responsive extension for DataTables -->
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>
    @yield('custom-scripts')
</body>
</html>
