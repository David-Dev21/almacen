@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('ingresos.index') }}">Ingresos</a></li>
    <li class="breadcrumb-item active">Detalles del Ingreso</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <div class="card-header bg-gradient-green">
            <h5 class="card-title text-white my-auto">Detalles del Ingreso</h5>
        </div>
        <!-- Cuerpo del card -->
        <div class="card-body d-flex flex-column" style="height: calc(100vh - 120px);">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex">
                        <strong>Proveedor:</strong><span class="ms-2">{{ $ingresos->nombre_proveedor }}</span>
                    </div>
                    <div class="d-flex">
                        <strong>Usuario:</strong><span class="ms-2">{{ $ingresos->nombre_usuario }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex">
                        <strong>Nro. de Factura:</strong><span class="ms-2">{{ $ingresos->n_factura }}</span>
                    </div>
                    <div class="d-flex">
                        <strong>Fecha:</strong><span class="ms-2">{{ $ingresos->fecha_hora }}</span>
                    </div>
                </div>
            </div>
            <!-- Tabla Responsiva -->
            <div class="table-responsive overflow-auto flex-grow-1 mt-3">
                <table class="table table-hover table-bordered align-middle" id="tableDetalles">
                    <thead class="table-secondary">
                        <tr class="text-center">
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unidad</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="text-center">
                            <th colspan="2"></th>
                            <th>TOTAL</th>
                            <th>
                                {{ $ingresos->total }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($detalles as $item)
                            <tr class="text-center">
                                <td>{{ $item->producto }}</td>
                                <td>{{ $item->cantidad_original }}</td>
                                <td>{{ $item->costo_u }}</td>
                                <td>{{ $item->cantidad_original * $item->costo_u }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
