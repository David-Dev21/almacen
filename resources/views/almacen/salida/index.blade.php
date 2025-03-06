@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Salidas</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <div class="card-header bg-gradient-green">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="text-white my-auto">LISTADO DE SALIDAS</h4>
                <form action="{{ route('salidas.index') }}" method="get">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="buscar" placeholder="Buscar" value="{{ $buscar }}">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <a href="{{ route('salidas.create') }}" class="btn btn-labeled btn-success">
                <span class="btn-label"><i class="bi bi-plus-circle-fill"></i></span>Nueva Salida
            </a>

            <div class="table-responsive mt-3">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-secondary">
                        <tr class="text-center">
                            <th>Unidad</th>
                            <th>Fecha y Hora</th>
                            <th>N° de Hoja de Ruta</th>
                            <th>N° de Pedido</th>
                            <th>Total</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salidas as $item)
                            <tr class="text-center">
                                <td>{{ $item->nombre_unidad }}</td>
                                <td>{{ $item->fecha_hora }}</td>
                                <td>{{ $item->n_hoja_ruta }}</td>
                                <td>{{ $item->n_pedido }}</td>
                                <td>{{ $item->total }}</td>
                                <td>
                                    <a href="{{ route('salidas.show', $item->id_salida) }}" class="btn btn-warning btn-labeled btn-small">
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
            {{ $salidas->links() }}
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
