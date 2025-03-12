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
                        <input type="text" class="form-control" name="buscar" value="{{ $buscar }}" data-bs-toggle="tooltip"
                            title="Ingrese el nro. de factura o nro. de pedido del ingreso que desea buscar" autocomplete="off">
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
                            <th>#</th>
                            <th>Proveedor</th>
                            <th>Nº de Factura</th>
                            <th>Nº de Pedido</th>
                            <th>Fecha y Hora</th>
                            <th>Total</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ingresos as $item)
                            <tr>
                                <td class="text-center">{{ $item->id_ingreso }}</td>
                                <td class="ps-2">{{ $item->nombre_proveedor }}</td>
                                <td class="ps-2">{{ $item->n_factura }}</td>
                                <td class="ps-2">{{ $item->n_pedido }}</td>
                                <td class="ps-2">{{ $item->fecha_hora }}</td>
                                <td class="text-end pe-2">{{ $item->total }}</td>
                                <td class="text-center">
                                    <a href="{{ route('ingresos.show', $item->id_ingreso) }}" class="btn btn-primary btn-labeled btn-small my-1">
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
