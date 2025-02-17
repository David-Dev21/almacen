@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Unidades</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <div class="card-header bg-gradient-green">
            <div class="d-flex flex-row justify-content-between">
                <h3 class="text-white my-auto">LISTADO DE UNIDADES</h3>
                <form action="{{ route('unidades.index') }}" method="get">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="buscar" placeholder="Buscar Unidad" value="{{ $buscar }}">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body">
            <a href="{{ route('unidades.create') }}" class="btn btn-labeled btn-success">
                <span class="btn-label"><i class="bi bi-plus-circle-fill"></i></span>Crear Unidad
            </a>

            <div class="table-responsive mt-3">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-secondary">
                        <tr class="text-center">
                            <th>Unidad</th>
                            <th>Jefe</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unidades as $item)
                            <tr class="text-center">
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->jefe }}</td>
                                <td>{{ $item->direccion }}</td>
                                <td>{{ $item->telefono }}</td>
                                <td>
                                    @if ($item->estado == 1)
                                        <span class="badge text-bg-success">Activo</span>
                                    @else
                                        <span class="badge text-bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('unidades.edit', $item->id_unidad) }}" class="btn btn-labeled btn-warning btn-small">
                                        <span class="btn-label"><i class="bi bi-pen-fill"></i></span>Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $unidades->links() }}
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
    </script>
    <script src="{{ asset('js/notifications.js') }}"></script>
@endpush
