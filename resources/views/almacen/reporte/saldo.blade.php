@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Saldo Almacén</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100 d-flex flex-column">
        <div class="card-header bg-gradient-green">
            <h4 class="text-white m-0 fw-bold">SALDO ALMACÉN</h4>
        </div>
        <div class="card-body">
            <!-- Formulario de Filtro -->
            <form action="{{ route('saldo') }}" method="GET">
                @csrf
                <!-- Fecha Final -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="flatpickr">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('fecha_fin') is-invalid @enderror" id="dateFechaFin" name="fecha_fin"
                                    placeholder="fecha_fin" value="{{ old('fecha_fin', request('fecha_fin')) }}" data-input>
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
                            <select class="form-select @error('id_categoria') is-invalid @enderror" id="selectCategoria" name="id_categoria">
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
                    <div class="col-md-4 d-flex align-items-center justify-content-around">
                        <button type="submit" class="btn btn-primary btn-labeled">
                            <span class="btn-label"><i class="bi bi-search"></i></span>Buscar
                        </button>
                        @if ($resultados['total_general']->total_cantidad_actual ?? 0 > 0)
                            <a id="imprimirButton"
                                href="{{ route('saldo.imprimir', ['fecha_fin' => request('fecha_fin'), 'categoria_id' => request('categoria_id')]) }}"
                                target="_blank" class="btn btn-labeled btn-danger">
                                <span class="btn-label"><i class="bi bi-file-pdf-fill"></i></span>Imprimir
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Resultados -->
            <div class="table-responsive overflow-auto mt-3">
                <table class="table table-hover table-bordered align-middle">
                    <thead>
                        <tr class="text-center align-middle">
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
                    @if (isset($resultados))
                        @if (isset($resultados['totales_por_producto']) && isset($resultados['totales_por_categoria']) && count($resultados['totales_por_producto']) > 0)
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
                                    <tr class="fw-bold">
                                        <td class="ps-2">
                                            <p class="my-1">{{ $codigoCategoria ? $codigoCategoria->codigo_categoria : '' }}</p>
                                        </td>
                                        <td colspan="5" class="ps-2">{{ $categoriaActual }}</td>
                                        <td class="text-end pe-4">{{ $totalCategoria ? $totalCategoria->total_cantidad_actual : '0' }}
                                        </td>
                                        <td class="text-end pe-4">{{ $totalCategoria ? $totalCategoria->total_valor_actual : '0.00' }}
                                        </td>
                                    </tr>
                                @endif

                                @php
                                    $esPrimeraFilaProducto =
                                        $index == 0 || $resultados['detalles'][$index - 1]->codigo_producto !== $detalle->codigo_producto;
                                    $totalProductoActual = $totalProducto[$detalle->codigo_producto] ?? null;
                                @endphp

                                <tr>
                                    <td class="ps-2">
                                        <p class="my-1">{{ $detalle->codigo_producto }}</p>
                                    </td>
                                    <td class="ps-2">{{ $detalle->producto }}</td>
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
                    @endif
                    </tbody>
                    @if (isset($resultados['detalles']) && count($resultados['detalles']) > 0)
                        <tfoot>
                            <tr class="fw-bold">
                                <th colspan="6" class="text-center">TOTAL GENERAL</th>
                                <th class="text-end pe-4">{{ $resultados['total_general']->total_cantidad_actual ?? '0' }} </th>
                                <th class="text-end pe-4">Bs: {{ number_format($resultados['total_general']->total_valor_actual ?? 0, 2) }}</th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#dateFechaFin", {
                dateFormat: "Y-m-d",
                locale: "es", // Idioma en español
                minDate: "2025-01-01",
                maxDate: "today" // Disable future dates
            });

            @if (request()->has('fecha_fin') && (!isset($resultados) || count($resultados['detalles']) === 0))
                Swal.fire({
                    icon: 'info',
                    title: 'Sin resultados',
                    text: 'No se encontraron saldos para la fecha seleccionada.',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false,
                    confirmButtonText: 'Aceptar',
                });
            @endif
        });
    </script>
@endpush
