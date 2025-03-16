<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Almacén</title>
    <link rel="icon" href="{{ asset('img/logo.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <aside class="d-flex flex-column bg-green text-white col-2 p-2">
                <div class="d-flex justify-content-center justify-content-md-start">
                    <img src="{{ asset('img/logo-para-pdf.jpg') }}" alt="Logo" width="40" height="40"
                        class="rounded-circle bg-green-light p-1">
                    <span class="text-green-light fw-bold fs-2 ms-2 d-none d-md-inline">ALMACÉN</span>
                </div>
                <ul class="nav flex-column flex-grow-1">
                    <li class="nav-item mt-3">
                        <div class="card-transparent text-center text-md-start">

                            <a href="{{ route('dashboard') }}" class="nav-link text-white bg-green-hover " data-bs-toggle="tooltip"
                                data-bs-placement="right" title="Inicio">
                                <i class="bi bi-house-fill"></i> <span class="d-none d-md-inline">Inicio</span></a>
                        </div>
                    </li>
                    <li class="nav-item my-2">
                        <span class="text-green-light">Gestión de Inventario</span>
                        <div class="card-transparent mt-2 text-center text-md-start">
                            <a href="{{ route('categorias.index') }}" class="nav-link text-white bg-green-hover" data-bs-toggle="tooltip"
                                data-bs-placement="right" title="Categorías">
                                <i class="bi bi-tags-fill"></i> <span class="d-none d-md-inline">Categorías</span></a>
                            <a href="{{ route('productos.index') }}" class="nav-link text-white bg-green-hover" data-bs-toggle="tooltip"
                                data-bs-placement="right" title="Productos">
                                <i class="bi bi-cart-fill"></i> <span class="d-none d-md-inline">Productos</span></a>

                        </div>
                    </li>
                    <li class="nav-item my-2">
                        <span class="text-green-light">Gestión de Ingresos</span>
                        <div class="card-transparent mt-2 text-center text-md-start">
                            <a href="{{ route('proveedores.index') }}" class="nav-link text-white bg-green-hover" data-bs-toggle="tooltip"
                                data-bs-placement="right" title="Proveedores">
                                <i class="bi bi-person-lines-fill"></i> <span class="d-none d-md-inline">Proveedores</span></a>
                            <a href="{{ route('ingresos.index') }}" class="nav-link text-white bg-green-hover" data-bs-toggle="tooltip"
                                data-bs-placement="right" title="Registrar Ingreso">
                                <i class="bi bi-file-earmark-plus"></i> <span class="d-none d-md-inline">Registrar Ingreso</span></a>
                        </div>
                    </li>
                    <li class="nav-item my-2">
                        <span class="text-green-light">Gestión de Salidas</span>
                        <div class="card-transparent mt-2 text-center text-md-start">
                            <a href="{{ route('unidades.index') }}" class="nav-link text-white bg-green-hover" data-bs-toggle="tooltip"
                                data-bs-placement="right" title="Unidades">
                                <i class="bi bi-building-fill"></i> <span class="d-none d-md-inline">Unidades</span></a>
                            <a href="{{ route('salidas.index') }}" class="nav-link text-white bg-green-hover" data-bs-toggle="tooltip"
                                data-bs-placement="right" title="Registrar Salida">
                                <i class="bi bi-file-earmark-minus"></i> <span class="d-none d-md-inline">Registrar Salida</span></a>
                        </div>
                    </li>
                    <li class="nav-item my-2">
                        <span class="text-green-light">Reportes</span>
                        <div class="card-transparent mt-2 text-center text-md-start">
                            <a href="{{ route('saldo') }}" class="nav-link text-white bg-green-hover" data-bs-toggle="tooltip"
                                data-bs-placement="right" title="Saldo Almacén">
                                <i class="bi bi-file-earmark-bar-graph"></i> <span class="d-none d-md-inline">Saldo Almacén</span></a>
                            <a href="{{ route('movimientos') }}" class="nav-link text-white bg-green-hover" data-bs-toggle="tooltip"
                                data-bs-placement="right" title="Movimiento Almacén">
                                <i class="bi bi-arrow-repeat"></i></i> <span class="d-none d-md-inline">Movimiento Almacén</span></a>
                        </div>
                    </li>
                </ul>
                <div class="btn-group dropup" data-bs-toggle="tooltip" data-bs-placement="right" title="Usuario">
                    <button class="btn text-white dropdown-toggle w-100 bg-green-hover" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <span class="d-none d-md-inline">{{ Auth::user()->ci }}</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <span class="dropdown-item">{{ Auth::user()->name }}</span>
                        </li>
                        {{-- <li><a class="dropdown-item" href="{{ route('usuarios.change-password') }}">Cambiar Contraseña</a></li>
                        <li> --}}
                        <hr class="dropdown-divider">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit">Cerrar Sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Content -->
            <main class="d-flex flex-column bg-green-medium col-10">
                <div class="w-100">
                    <nav class="bg-green-light rounded shadow-lg">
                        <ol class="breadcrumb p-1 my-1 fw-bold">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="link">
                                    <i class="bi bi-house-fill me-2"></i>Inicio</a>
                            </li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
                <!-- contenido -->
                <div class="d-flex justify-content-center h-100">
                    @yield('contenido')
                </div>
                <!-- contenido -->
                <!-- Footer -->
                <footer class="text-center mt-auto">
                    <span class="text-muted">&copy; 2025 | Desarrollado por
                        <a href="https://www.linkedin.com/in/david-mamani-a3b745352/" target="_blank" class="link">
                            RubenDavidMA
                        </a>
                        <a href="https://github.com/David-Dev21" target="_blank" class="link">
                            <i class="bi bi-github"></i>
                        </a></span>
                </footer>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
