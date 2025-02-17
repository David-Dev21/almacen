@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('salidas.index') }}">Salidas</a></li>
    <li class="breadcrumb-item active">Detalles de la Salida</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <div class="card-header bg-gradient-green">
            <div class="row">
                <div class="col-6">
                    <h5 class="card-title text-white my-auto">Detalles de la Salida</h5>
                </div>
                <div class="col-6">
                    <a href="{{ route('reporte-salida', $salida->id_salida) }}" class="btn btn-labeled btn-danger float-end">
                        <span class="btn-label"><i class="bi bi-file-pdf-fill"></i></span>Generar Reporte PDF
                    </a>
                </div>
            </div>
        </div>
        <!-- Cuerpo del card -->
        <div class="card-body d-flex flex-column" style="height: calc(100vh - 120px);">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex">
                        <strong>Unidad:</strong><span class="ms-2">{{ $salida->nombre_unidad }}</span>
                    </div>
                    <div class="d-flex">
                        <strong>Hoja de Ruta:</strong><span class="ms-2">{{ $salida->n_hoja_ruta }}</span>
                    </div>
                    <div class="d-flex">
                        <strong>Pedido:</strong><span class="ms-2">{{ $salida->n_pedido }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex">
                        <strong>Usuario:</strong><span class="ms-2">{{ $salida->nombre_usuario }}</span>
                    </div>
                    <div class="d-flex">
                        <strong>Unidad:</strong><span class="ms-2">{{ $salida->nombre_unidad }}</span>
                    </div>
                    <div class="d-flex">
                        <strong>Fecha:</strong><span class="ms-2">{{ $salida->fecha_hora }}</span>
                    </div>
                </div>
            </div>
            <!-- Tabla Responsiva -->
            <div class="table-responsive overflow-auto flex-grow-1 mt-3">
                <table class="table table-hover table-bordered align-middle" id="tableDetalles">
                    <thead class="table-secondary">
                        <tr class="text-center">
                            <th>Item</th>
                            <th>Producto</th>
                            <th>Unidad</th>
                            <th>Lote</th>
                            <th>Cantidad</th>
                            <th>Precio Unidad</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="text-center">
                            <th colspan="5"></th>
                            <th>TOTAL</th>
                            <th>
                                {{ $salida->total }}
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($detalles as $item)
                            <tr class="text-center">
                                <td>{{ $item->codigo }}</td>
                                <td>{{ $item->producto }}</td>
                                <td>{{ $item->unidad }}</td>
                                <td>{{ $item->lote }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ $item->costo_u }}</td>
                                <td>{{ $item->cantidad * $item->costo_u }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
