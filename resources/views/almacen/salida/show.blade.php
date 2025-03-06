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
            </div>
        </div>
        <!-- Cuerpo del card -->
        <div class="card-body d-flex flex-column" style="height: calc(100vh - 120px);">
            <div class="row">
                <div class="col-md-5">
                    <div class="d-flex">
                        <strong>Destino:</strong><span class="ms-2">{{ $salida->nombre_unidad }}</span>
                    </div>
                    <div class="d-flex">
                        <strong>Hoja de Ruta:</strong><span class="ms-2">{{ $salida->n_hoja_ruta }}</span>
                    </div>
                    <div class="d-flex">
                        <strong>Pedido:</strong><span class="ms-2">{{ $salida->n_pedido }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex">
                        <strong>Nº Egreso:</strong><span class="ms-2">{{ $salida->id_salida }}</span>
                    </div>
                    <div class="d-flex">
                        <strong>Usuario:</strong><span class="ms-2">{{ $salida->nombre_usuario }}</span>
                    </div>
                    <div class="d-flex">
                        <strong>Fecha:</strong><span class="ms-2">{{ $salida->fecha_hora }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('reporte-salida', ['id' => $salida->id_salida, 'mostrarCostos' => true]) }}" target="_blank"
                        class="btn btn-labeled btn-danger my-1">
                        <span class="btn-label"><i class="bi bi-file-pdf-fill"></i></span>Con Valorada
                    </a>
                    <a href="{{ route('reporte-salida', ['id' => $salida->id_salida, 'mostrarCostos' => false]) }}" target="_blank"
                        class="btn btn-labeled btn-danger my-1">
                        <span class="btn-label"><i class="bi bi-file-pdf-fill"></i></span>Sin Valorada
                    </a>
                </div>
            </div>
            <!-- Tabla Responsiva -->
            <div class="table-responsive overflow-auto flex-grow-1 mt-3">
                <table class="table table-hover table-bordered align-middle" id="tableDetalles">
                    <thead class="table-secondary">
                        <tr class="text-center">
                            <th>Codigo</th>
                            <th>Producto</th>
                            <th>Unidad</th>
                            <th>Lote</th>
                            <th>Cantidad</th>
                            <th>Costo Unitario</th>
                            <th>Costo Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $categoriaActual = null;
                            $totalCantidad = 0;
                            $totalCostoUnitario = 0;
                            $totalCostoTotal = 0;
                        @endphp

                        @foreach ($detalles as $item)
                            @if ($categoriaActual !== $item->categoria)
                                @php
                                    $categoriaActual = $item->categoria;
                                    $codigoCategoria = $item->codigo_categoria;
                                @endphp
                                <tr>
                                    <td class="ps-4"><strong>{{ $codigoCategoria }}</strong></td>
                                    <td colspan="6" class="ps-4"><strong>{{ $categoriaActual }}</strong></td>
                                </tr>
                            @endif
                            <tr>
                                <td class="ps-4">{{ $item->codigo_producto }}</td>
                                <td class="ps-4">{{ $item->producto }}</td>
                                <td>{{ $item->unidad }}</td>
                                <td>{{ $item->lote }}</td>
                                <td class="text-end pe-4">{{ $item->cantidad }}</td>
                                <td class="text-end pe-4">{{ number_format($item->costo_u, 2) }}</td>
                                <td class="text-end pe-4">{{ number_format($item->cantidad * $item->costo_u, 2) }}</td>
                            </tr>
                            @php
                                $totalCantidad += $item->cantidad;
                                $totalCostoUnitario += $item->costo_u;
                                $totalCostoTotal += $item->cantidad * $item->costo_u;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-center">TOTAL GENERAL</th>
                            <th class="text-end pe-4">{{ $totalCantidad }}</th>
                            <th class="text-end pe-4">{{ number_format($totalCostoUnitario, 2) }}</th>
                            <th class="text-end pe-4">{{ number_format($totalCostoTotal, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection
