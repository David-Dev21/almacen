@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Saldo Almacén</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100 d-flex flex-column" style="height: calc(100vh - 60px);">
        <div class="card-header bg-gradient-green">
            <h4 class="text-white my-auto">Saldo Almacén</h4>
        </div>
        <div class="card-body">
            <!-- Formulario de Filtro -->
            <form action="{{ route('saldo') }}" method="GET" class="row mb-2">
                @csrf
                <!-- Fecha Final -->
                <div class="col-md-4">
                    <div class="flatpickr">
                        <div class="form-floating">
                            <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror" id="dateFechaFin" name="fecha_fin"
                                placeholder="" value="{{ old('fecha_fin', request('fecha_fin')) }}" data-input>
                            <label for="dateFechaFin">Fecha Fin</label>
                            @error('fecha_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Categoría -->
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-control @error('id_categoria') is-invalid @enderror" id="selectCategoria" name="id_categoria">
                            <option value="">Todas las Categorías</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}"
                                    {{ old('id_categoria', request('id_categoria')) == $categoria->id_categoria ? 'selected' : '' }}>
                                    {{ $categoria->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        <label for="selectCategoria">Categoría</label>
                        @error('id_categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Botón Filtrar -->
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn btn-primary w-50">Filtrar</button>
                    <a href="{{ route('saldo.imprimir', ['fecha_fin' => request('fecha_fin'), 'categoria_id' => request('categoria_id')]) }}"
                        target="_blank" class="btn btn-secondary w-50 ms-2">Imprimir Reporte</a>
                </div>
            </form>

            <!-- Resultados -->
            <div class="table-responsive overflow-auto flex-grow-1">
                @if (isset($resultados))
                    <table class="table table-hover table-bordered align-middle">
                        @if (isset($resultados['totales_por_producto']) && isset($resultados['totales_por_categoria']) && count($resultados['totales_por_producto']) > 0)
                            <thead class="table-secondary">
                                <tr class="text-center align-middle sticky-top">
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Unidad</th>
                                    <th>Lote</th>
                                    <th>Cantidad</th>
                                    <th>Valor</th>
                                    <th>Cantidad <br> Total</th>
                                    <th>Valor <br> Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $categoriaActual = null;
                                    $totalProducto = [];
                                    foreach ($resultados['totales_por_producto'] as $total) {
                                        $totalProducto[$total->codigo_producto] = $total;
                                    }
                                @endphp
                        @endif

                        @if (isset($resultados['detalles']))
                            @php
                                $productoRowspan = [];
                                foreach ($resultados['detalles'] as $detalle) {
                                    $productoRowspan[$detalle->codigo_producto] = ($productoRowspan[$detalle->codigo_producto] ?? 0) + 1;
                                }
                            @endphp

                            @foreach ($resultados['detalles'] as $index => $detalle)
                                @if ($categoriaActual !== $detalle->categoria)
                                    @php
                                        $categoriaActual = $detalle->categoria;
                                        $totalCategoria = collect($resultados['totales_por_categoria'])->firstWhere('categoria', $categoriaActual);
                                        $codigoCategoria = collect($resultados['totales_por_categoria'])->firstWhere('categoria', $categoriaActual);
                                    @endphp
                                    <tr>
                                        <td class="ps-4"><strong>{{ $codigoCategoria ? $codigoCategoria->codigo_categoria : '' }}</strong>
                                        </td>
                                        <td colspan="5" class="ps-4"><strong>{{ $categoriaActual }}</strong></td>
                                        <td class="text-end pe-4"><strong>{{ $totalCategoria ? $totalCategoria->total_cantidad_actual : '0' }}</strong>
                                        </td>
                                        <td class="text-end pe-4"><strong>{{ $totalCategoria ? $totalCategoria->total_valor_actual : '0.00' }}</strong>
                                        </td>
                                    </tr>
                                @endif

                                @php
                                    $esPrimeraFilaProducto =
                                        $index == 0 || $resultados['detalles'][$index - 1]->codigo_producto !== $detalle->codigo_producto;
                                    $totalProductoActual = $totalProducto[$detalle->codigo_producto] ?? null;
                                @endphp

                                <tr>
                                    <td class="ps-4">{{ $detalle->codigo_producto }}</td>
                                    <td class="ps-4">{{ $detalle->producto }}</td>
                                    <td class="ps-4">{{ $detalle->unidad }}</td>
                                    <td class="ps-4">{{ $detalle->lote }}</td>
                                    <td class="text-end pe-4">{{ $detalle->cantidad_actual }}</td>
                                    <td class="text-end pe-4">{{ $detalle->costo_total_lote }}</td>

                                    @if ($esPrimeraFilaProducto)
                                        <td rowspan="{{ $productoRowspan[$detalle->codigo_producto] ?? 1 }}" class="text-end pe-4">
                                            {{ $totalProductoActual->total_cantidad_actual ?? '0' }}
                                        </td>
                                        <td rowspan="{{ $productoRowspan[$detalle->codigo_producto] ?? 1 }}" class="text-end pe-4">
                                            {{ $totalProductoActual->total_valor_actual ?? '0.00' }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot class="table-secondary">
                            @if (!empty($resultados['total_general']))
                                <tr class="fw-bold text-center">
                                    <td colspan="6">TOTAL GENERAL</td>
                                    <td>{{ $resultados['total_general']->total_cantidad_actual }}</td>
                                    <td>{{ number_format($resultados['total_general']->total_valor_actual, 2) }}</td>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                @endif
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#dateFechaFin", {
            dateFormat: "Y-m-d",
            locale: "es", // Idioma en español
        });
        document.addEventListener('DOMContentLoaded', function() {
            @if (request()->has('fecha_fin') && (!isset($resultados) || count($resultados['detalles']) === 0))
                Swal.fire({
                    icon: 'info',
                    title: 'Sin resultados',
                    text: 'No se encontraron movimientos para la fecha seleccionada.',
                    confirmButtonText: 'Aceptar'
                });
            @endif
        });
    </script>
@endpush
