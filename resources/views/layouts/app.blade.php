<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite('resources/css/app.css')

</head>

<body>
    <div class="container-fluid vh-100 bg-secondary" id="app">
        <div class="row h-100">
            <div class="col-6 bg-green">
                <div class="d-flex flex-column h-100 justify-content-center align-items-center">
                    <h1 class="text-green-light fw-bold mb-5">Bienvenido al Sistema de Almacén</h1>
                    <img class="img-fluid w-50 rounded-circle" src="{{ asset('img/logo-policia.jpg') }}" alt="">
                </div>
            </div>
            <div class="col-6 bg-green-light">
                <div class="d-flex flex-column h-100 justify-content-center align-items-center">
                    @yield('content')
                </div>
            </div>
        </div>

    </div>
    <!-- Antes de cerrar el body -->
    @vite('resources/js/app.js')
</body>

</html>
