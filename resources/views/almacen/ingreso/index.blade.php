@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Ingresos</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <div class="card-header bg-gradient-green">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="text-white my-auto">LISTADO DE INGRESOS</h4>
                <form action="{{ route('ingresos.index') }}" method="get">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="buscar" placeholder="Buscar" value="{{ $buscar }}">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body">
            <a href="{{ route('ingresos.create') }}" class="btn btn-labeled btn-success">
                <span class="btn-label"><i class="bi bi-plus-circle-fill"></i></span>Nuevo Ingreso
            </a>

            <div class="table-responsive mt-3">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-secondary">
                        <tr class="text-center">
                            <th>Id</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Nro de Factura</th>
                            <th>Fecha y Hora</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ingresos as $item)
                            <tr class="text-center">
                                <td>{{ $item->id_ingreso }}</td>
                                <td>{{ $item->nombre_proveedor }}</td>
                                <td>{{ $item->nombre_usuario }}</td>
                                <td>{{ $item->n_factura }}</td>
                                <td>{{ $item->fecha_hora }}</td>
                                <td>{{ $item->estado }}</td>
                                <td>{{ $item->total }}</td>
                                <td>
                                    <a href="{{ route('ingresos.show', $item->id_ingreso) }}" class="btn btn-warning btn-labeled btn-small">
                                        <span class="btn-label"><i class="bi bi-eye-fill"></i></span>Ver
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-auto">
            {{ $ingresos->links() }}
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
