<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


    <!-- Include compiled app.js -->
    <script src="{{ mix('resources/js/app.js') }}"></script>

    {{-- CSS --}}
    @vite(['/resources/css/app.css'])
    @vite(['/resources/css/bootstrap-min.css'])
    @vite(['/resources/css/login.css'])
    @vite(['/resources/css/styles.css'])



    {{-- JAVASCRIPT --}}
    @vite(['js/app.js'])
    @vite(['resources/js/app.js'])
    @vite('resources/sass/app.scss')


</head>

<body class="sb-nav-fixed">
    @yield('content')
    @vite('resources/js/app.js')
    @include('sweetalert::alert')
    @stack('scripts')


</body>

</html>
