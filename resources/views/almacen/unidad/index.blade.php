@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Unidades</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <div class="card-header bg-gradient-green">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="text-white my-auto fw-bold">LISTADO DE UNIDADES</h4>
                <form action="{{ route('unidades.index') }}" method="get">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="buscar" value="{{ $buscar }}" data-bs-toggle="tooltip"
                            title="Ingrese el nombre de la unidad que desea buscar" autocomplete="off"> <button class="btn btn-primary"
                            type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <a href="{{ route('unidades.create') }}" class="btn btn-labeled btn-success fw-bold">
                <span class="btn-label"><i class="bi bi-plus-lg"></i></span>Crear Unidad
            </a>
            <div class="table-responsive mt-3">
                <table class="table table-hover table-bordered align-middle">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Jefe</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>teléfono</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unidades as $item)
                            <tr>
                                <td class="text-center">{{ $item->id_unidad }}</td>
                                <td class="ps-2">{{ $item->jefe }}</td>
                                <td class="ps-2">{{ $item->nombre }}</td>
                                <td class="ps-2">{{ $item->direccion }}</td>
                                <td class="ps-2">{{ $item->telefono }}</td>
                                <td class="text-center">
                                    <button class="btn"
                                        onclick="confirmToggleEstado({{ $item->id_unidad }}, {{ $item->estado }}, '{{ $item->nombre }}')">
                                        <span class="badge {{ $item->estado == 1 ? 'text-bg-success' : 'text-bg-danger' }}">
                                            {{ $item->estado == 1 ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('unidades.edit', $item->id_unidad) }}" class="btn btn-labeled btn-warning btn-small">
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
            {{ $unidades->links() }}
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        var successMessage = "{{ session('success') }}";
        var errorMessage = "{{ session('error') }}";

        function confirmToggleEstado(id, currentEstado, nombre) {
            Swal.fire({
                title: '¿Estás seguro?',
                html: `¡Estás a punto de cambiar el estado de la unidad: <strong>${nombre}</strong>!`,
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

            fetch(`/unidades/${id}/toggle`, {
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
