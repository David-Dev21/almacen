<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Almacén</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Sidebar -->
            <aside class="d-flex flex-column bg-green text-white col-2 p-2">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('img/logo-policia.jpg') }}" alt="Logo" width="40" height="40" class="rounded-circle">
                    <span class="text-white fw-bold ms-2">ALMACÉN</span>
                </div>
                <ul class="nav flex-column flex-grow-1">
                    <li class="nav-item mt-3">
                        <div class="card-transparent">
                            <a href="{{ route('dashboard') }}" class="nav-link text-white bg-green-hover">
                                <i class="bi bi-house-fill"></i> Inicio</a>
                        </div>
                    </li>
                    <li class="nav-item my-2">
                        <span class="text-green-light ps-2">Gestión de Inventario</span>
                        <div class="card-transparent mt-2">
                            <a href="{{ route('categorias.index') }}" class="nav-link text-white bg-green-hover">
                                <i class="bi bi-tags-fill"></i> Categorías</a>
                            <a href="{{ route('productos.index') }}" class="nav-link text-white bg-green-hover">
                                <i class="bi bi-cart-fill"></i> Productos</a>

                        </div>
                    </li>
                    <li class="nav-item my-2">
                        <span class="text-green-light ps-2">Gestión de Ingresos</span>
                        <div class="card-transparent mt-2">
                            <a href="{{ route('proveedores.index') }}" class="nav-link text-white bg-green-hover">
                                <i class="bi bi-box-seam-fill"></i> Proveedores</a>
                            <a href="{{ route('ingresos.index') }}" class="nav-link text-white bg-green-hover">
                                <i class="bi bi-file-earmark-plus-fill"></i> Registrar Ingreso</a>
                        </div>
                    </li>
                    <li class="nav-item my-2">
                        <span class="text-green-light ps-2">Gestión de Salidas</span>
                        <div class="card-transparent mt-2">
                            <a href="{{ route('unidades.index') }}" class="nav-link text-white bg-green-hover">
                                <i class="bi bi-building-fill"></i> Unidades</a>
                            <a href="{{ route('salidas.index') }}" class="nav-link text-white bg-green-hover">
                                <i class="bi bi-file-earmark-minus-fill"></i> Registrar Salida</a>
                        </div>
                    </li>
                    <li class="nav-item my-2">
                        <span class="text-green-light ps-2">Reportes</span>
                        <div class="card-transparent mt-2">
                            <a href="{{ route('saldo') }}" class="nav-link text-white bg-green-hover">
                                <i class="bi bi-building-fill"></i> Saldos de Almacén</a>
                            <a href="{{ route('movimientos') }}" class="nav-link text-white bg-green-hover">
                                <i class="bi bi-file-earmark-minus-fill"></i> Movimiento de Almacén</a>
                        </div>
                    </li>
                    <li class="nav-item my-2">
                        <div class="card-transparent">
                            <a href="{{ route('usuarios.index') }}" class="nav-link text-white text-start bg-green-hover">
                                <i class="bi bi-people-fill me-2"></i>Usuarios
                            </a>
                        </div>
                    </li>
                </ul>
                <div class="btn-group dropup">
                    <button class="btn text-white dropdown-toggle w-100 bg-green-hover" type="button" id="userDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-person-fill"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">{{ Auth::user()->name }}</a></li>
                        <li><a class="dropdown-item" href="#"></a></li>
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-fill me-2"></i>Inicio</a>
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
                    <span class="text-muted">&copy; 2025 Your Brand. All rights reserved.</span>
                </footer>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>

</html>
