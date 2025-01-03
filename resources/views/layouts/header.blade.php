<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- AdminLTE CSS -->
    @vite(['resources/admin-lte-4.0/css/adminlte.css'])
    @vite(['resources/css/main-style.css'])
    @yield('additional_style')

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-PI8n5gCcz9cQqQXm3PEtDuPG8qx9oFsFctPg0S5zb8g=" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css" integrity="sha256-rKBEfnQsmpf8CmrOAohl7rVNfVUf+8mtA/8AKfXN7YA=" crossorigin="anonymous">

    <!-- DataTables Responsive extension CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.min.css" integrity="sha256-LliUrn7vT0PjsdPWfsGcQdDPMI0faaUPWzVGQahZkCQ=" crossorigin="anonymous">

    <!-- DataTables Buttons extension CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.bootstrap5.min.css" integrity="sha256-inPB99Z0Y2Ijp7YHBoE4K2W7CoUcM6YZ+aK4CgjrPY8=" crossorigin="anonymous">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand navbar-dark navbar-primary fixed-top"> <!--begin::Container-->
            <div class="container-fluid">
                <ul class="navbar-nav nav-head-obj">
                    <li class="nav-item w-100 d-flex justify-content-center">
                        @yield('navbar_header_button')
                    </li>
                    @yield('navbar_header_button_second')
                </ul>
                <ul class="navbar-nav mr-4">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm" style="background-color: white; color:black;"><i class="nav-icon bi bi-box-arrow-right"></i></button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="{{ route('admin.dashboard') }}" class="brand-link">
                    <span class="brand-text fw-light">Hotel Panel</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link @yield('dashboard_navbar_state')">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @endrole
                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.rooms.index') }}" class="nav-link @yield('rooms_navbar_state')">
                                <i class="nav-icon bi bi-door-open"></i>
                                <p>Rooms</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.rooms.properties.index') }}" class="nav-link @yield('room_properties_navbar_state')">
                                <i class="nav-icon bi bi-aspect-ratio"></i>
                                <p>Room properties</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.services.index') }}" class="nav-link @yield('services_navbar_state')">
                                <i class="nav-icon bi bi-bag-check"></i>
                                <p>Additional Services</p>
                            </a>
                        </li>
                        @endrole
                        @role('receptionist')
                        <li class="nav-item">
                            <a href="{{ route('receptionist.rooms.index') }}" class="nav-link @yield('rooms_navbar_state')">
                                <i class="nav-icon bi bi-door-open"></i>
                                <p>Rooms</p>
                            </a>
                        </li>
                        @endrole
                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.booking.index') }}" class="nav-link @yield('booking_navbar_state')">
                                <i class="nav-icon bi bi-calendar-week"></i>
                                <p>Booking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.guests.index') }}" class="nav-link @yield('guests_navbar_state')">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Guests</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.employees.index') }}" class="nav-link @yield('employees_navbar_state')">
                                <i class="nav-icon bi bi-person-workspace"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                        @endrole
                        @role('receptionist')
                        <li class="nav-item">
                            <a href="{{ route('receptionist.booking.index') }}" class="nav-link @yield('booking_navbar_state')">
                                <i class="nav-icon bi bi-calendar-week"></i>
                                <p>Booking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('receptionist.guests.index') }}" class="nav-link @yield('guests_navbar_state')">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Guests</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('receptionist.employees.index') }}" class="nav-link @yield('employees_navbar_state')">
                                <i class="nav-icon bi bi-person-workspace"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                        @endrole
                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link @yield('users_navbar_state')">
                                <i class="nav-icon bi bi-person-lines-fill"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        @endrole
                    </ul>
                </nav>
            </div>
        </aside>


        <main class="app-main">
            @yield('content')
        </main>
    </div>
    <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">Somethng</div><strong>
                2025
            </strong>
        </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha256-CDOy6cOibCWEdsRiZuaHf8dSGGJRYuBGC+mjoJimHGw=" crossorigin="anonymous"></script>
    
    @vite(['resources/admin-lte-4.0/js/adminlte.js'])
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js" integrity="sha256-aTBve1VKWozmjo9Nb2E73RvP4t8xOWLn/IPPX2vl4IU=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js" integrity="sha256-U3zt3BGRnSBU8GxdNWp9CGmrMKBUthlz2ia7LERbiNc=" crossorigin="anonymous"></script>


    <!-- Bootstrap JS (required for DataTables with Bootstrap) -->
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.min.js" integrity="sha256-2SmX/IhbmVdeg5paUsa6SExqBi0iF2LF+Dh7tG/Uv7s=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.bootstrap5.min.js" integrity="sha256-dU1f0caF6eBMRglcDQ2xQ0oLhXNConpBNc2JSFeINL8=" crossorigin="anonymous"></script>

    <!-- Responsive extension for DataTables -->
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js" integrity="sha256-fgKMuTMhdhI9JaA6XdUSrgkOY41nWaeN5eH1ctK4yog=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.min.js" integrity="sha256-Ml0aZ+BzTKuF3cSJIyCElyJjEVFJjqoFucYGL6/hsmI=" crossorigin="anonymous"></script>
    
    @yield('custom-scripts')
</body>

</html>