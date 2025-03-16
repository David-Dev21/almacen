@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Productos</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <div class="card-header bg-gradient-green">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="text-white my-auto fw-bold">LISTADO DE PRODUCTOS</h4>
                <form action="{{ route('productos.index') }}" method="get">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="buscar" value="{{ $buscar }}" data-bs-toggle="tooltip"
                            title="Ingrese el código o la descripción del producto que desea buscar" autocomplete="off"> <button class="btn btn-primary"
                            type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <a href="{{ route('productos.create') }}" class="btn btn-labeled btn-success fw-bold">
                <span class="btn-label"><i class="bi bi-plus-lg"></i></span>Crear Producto
            </a>
            <div class="table-responsive mt-3">
                <table class="table table-hover table-bordered align-middle">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Unidad</th>
                            <th>Stock</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $item)
                            <tr>
                                <td class="text-center">{{ $item->id_producto }}</td>
                                <td class="ps-4">{{ $item->codigo }}</td>
                                <td class="ps-4">{{ $item->descripcion }}</td>
                                <td class="ps-4">{{ $item->unidad }}</td>
                                @if ($item->stock <= 10)
                                    <td class="bg-danger-subtle text-danger-emphasis fw-bold text-end pe-3">{{ $item->stock }}</td>
                                @else
                                    <td class="bg-success-subtle text-success-emphasis fw-bold text-end pe-3">{{ $item->stock }}</td>
                                @endif
                                <td class="ps-4">{{ $item->categoria->descripcion }}</td> <!-- Display category name -->
                                <td class="text-center">
                                    <button class="btn"
                                        onclick="confirmToggleEstado({{ $item->id_producto }}, {{ $item->estado }}, '{{ $item->descripcion }}')">
                                        <span class="badge {{ $item->estado == 1 ? 'text-bg-success' : 'text-bg-danger' }}">
                                            {{ $item->estado == 1 ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('productos.edit', $item->id_producto) }}" class="btn btn-labeled btn-warning btn-small">
                                        <span class="btn-label"><i class="bi bi-pen-fill"></i></span>Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-auto">
            {{ $productos->links() }}
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        var successMessage = "{{ session('success') }}";
        var errorMessage = "{{ session('error') }}";

        function confirmToggleEstado(id, currentEstado, descripcion) {
            Swal.fire({
                title: '¿Estás seguro?',
                html: `¡Estás a punto de cambiar el estado del producto: <strong>${descripcion}</strong>!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0B5ED7',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cambiar estado',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    toggleEstado(id, currentEstado);
                }
            });
        }

        function toggleEstado(id, currentEstado) {
            var newEstado = currentEstado == 1 ? 0 : 1;

            fetch(`/productos/${id}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        estado: newEstado
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al actualizar el estado');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al actualizar el estado');
                });
        }
    </script>
@endpush
