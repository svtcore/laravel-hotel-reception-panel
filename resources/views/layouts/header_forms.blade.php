<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Your custom styles -->
    @vite(['resources/css/forms.css'])
</head>
<body class="hold-transition sidebar-mini layout-fixed">
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
</body>
</html>
