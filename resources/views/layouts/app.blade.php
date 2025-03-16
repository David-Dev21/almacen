<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/logo.ico') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container-fluid vh-100 bg-secondary" id="app">
        <div class="row h-100">
            <div class="col-md-6 bg-green">
                <div class="d-flex flex-column h-100 justify-content-center align-items-center">
                    <h1 class="text-green-light fw-bold mb-md-5">Bienvenido al Sistema de Almacén</h1>
                    <img class="img-fluid w-50 rounded-circle d-none d-md-block" src="{{ asset('img/logo-policia.jpg') }}" alt="inicio">
                </div>
            </div>
            <div class="col-md-6 bg-green-light">
                <div class="d-flex flex-column h-100 justify-content-center align-items-center">
                    @yield('content')
                </div>
            </div>
        </div>

    </div>
</body>

</html>
