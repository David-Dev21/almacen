@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Proveedores</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <div class="card-header bg-gradient-green">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="text-white my-auto">LISTADO DE PROVEEDORES</h4>
                <form action="{{ route('proveedores.index') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="buscar" value="{{ $buscar }}" data-bs-toggle="tooltip"
                            title="Ingrese el nombre del proveedor que desea buscar" autocomplete="off"> <button class="btn btn-primary"
                            type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body">
            <a href="{{ route('proveedores.create') }}" class="btn btn-labeled btn-success">
                <span class="btn-label"><i class="bi bi-plus-circle-fill"></i></span>Crear Proveedor
            </a>
            <div class="table-responsive mt-3">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-secondary">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Razón Social</th>
                            <th>Nombre</th>
                            <th>Nº NIT</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedores as $item)
                            <tr>
                                <td class="text-center">{{ $item->id_proveedor }}</td>
                                <td class="ps-2">{{ $item->razon_social }}</td>
                                <td class="ps-2">{{ $item->nombre }}</td>
                                <td class="ps-2">{{ $item->nit }}</td>
                                <td class="ps-2">{{ $item->direccion }}</td>
                                <td class="ps-2">{{ $item->telefono }}</td>
                                <td class="text-center">
                                    <button class="btn"
                                        onclick="confirmToggleEstado({{ $item->id_proveedor }}, {{ $item->estado }}, '{{ $item->nombre }}')">
                                        <span class="badge {{ $item->estado == 1 ? 'text-bg-success' : 'text-bg-danger' }}">
                                            {{ $item->estado == 1 ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('proveedores.edit', $item->id_proveedor) }}" class="btn btn-labeled btn-warning btn-small">
                                        <span class="btn-label"><i class="bi bi-pen-fill"></i></span>Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $proveedores->links() }}
            </div>
        </div>
        <div class="mt-auto">
            {{ $proveedores->links() }}
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var successMessage = "{{ session('success') }}";
        var errorMessage = "{{ session('error') }}";

        function confirmToggleEstado(id, currentEstado, nombre) {
            Swal.fire({
                title: '¿Estás seguro?',
                html: `¡Estás a punto de cambiar el estado del proveedor: <strong>${nombre}</strong>!`,
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

            fetch(`/proveedores/${id}/toggle`, {
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
    <script src="{{ asset('js/notifications.js') }}"></script>
@endpush
