@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Salidas</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <div class="card-header bg-gradient-green">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="text-white my-auto fw-bold">LISTADO DE SALIDAS</h4>
                <form action="{{ route('salidas.index') }}" method="get">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="buscar" value="{{ $buscar }}" data-bs-toggle="tooltip"
                            title="Ingrese el nro. de hoja o nro. de pedido de ruta de la salida que desea buscar" autocomplete="off"> <button
                            class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <a href="{{ route('salidas.create') }}" class="btn btn-labeled btn-success fw-bold">
                <span class="btn-label"><i class="bi bi-plus-lg"></i></span>Registrar Salida
            </a>

            <div class="table-responsive mt-3">
                <table class="table table-hover table-bordered align-middle">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
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
                            <tr>
                                <td class="text-center">{{ $item->id_salida }}</td>
                                <td class="ps-2">{{ $item->nombre_unidad }}</td>
                                <td class="ps-2">{{ $item->fecha_hora }}</td>
                                <td class="ps-2">{{ $item->n_hoja_ruta }}</td>
                                <td class="ps-2">{{ $item->n_pedido }}</td>
                                <td class="text-end pe-2">{{ $item->total }}</td>
                                <td class="text-center">
                                    <a href="{{ route('salidas.show', $item->id_salida) }}" class="btn btn-warning btn-labeled btn-small my-1">
                                        <span class="btn-label"><i class="bi bi-eye-fill"></i></span>Detalles
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
@endpush
