@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Reporte Movimiento</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100 d-flex flex-column" style="height: calc(100vh - 60px);">
        <div class="card-header bg-gradient-green">
            <h4 class="text-white my-auto">Movimientos de Inventario</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('movimientos') }}" method="GET" class="row mb-2">
                @csrf
                <!-- Fecha Inicial -->
                <div class="col-md-4">
                    <div class="flatpickr">
                        <div class="form-floating">
                            <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" id="dateFechaInicio"
                                name="fecha_inicio" placeholder="" value="{{ old('fecha_inicio', request('fecha_inicio')) }}" data-input>
                            <label for="dateFechaInicio">Fecha Inicio</label>
                            @error('fecha_inicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

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
                <!-- Botón Filtrar -->
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn btn-primary w-50">Filtrar</button>
                    <a href="{{ route('movimientos.imprimir', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')]) }}"
                        target="_blank" class="btn btn-secondary w-50 ms-2">Imprimir Reporte</a>
                </div>
            </form>
            <div class="table-responsive overflow-auto flex-grow-1">
                @if (isset($productos) && count($productos) > 0)
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-secondary">
                            <tr class="text-center sticky-top">
                                <th rowspan="2" class="align-middle">Código</th>
                                <th rowspan="2" class="align-middle">Producto</th>
                                <th rowspan="2" class="align-middle">Lote</th>
                                <th rowspan="2" class="align-middle">Fecha</th>
                                <th colspan="2">Saldo Inicial</th>
                                <th colspan="2">Ingresos</th>
                                <th colspan="2">Salidas</th>
                                <th colspan="2">Saldo Final</th>
                            </tr>
                            <tr class="text-center">
                                <th>Cantidad</th>
                                <th>Valor</th>
                                <th>Cantidad</th>
                                <th>Valor</th>
                                <th>Cantidad</th>
                                <th>Valor</th>
                                <th>Cantidad</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $item)
                                <tr>
                                    <td class="ps-4">{{ $item->Codigo }}</td>
                                    <td class="ps-4">{{ $item->Producto }}</td>
                                    <td class="ps-4">{{ $item->Lote }}</td>
                                    <td class="ps-4">{{ $item->Fecha_Movimiento }}</td>
                                    <td class="text-end pe-2">{{ $item->Saldo_Inicial }}</td>
                                    <td class="text-end pe-2">{{ $item->Costo_Inicial }}</td>
                                    <td class="text-end pe-2">{{ $item->Ingresos_Cantidad }}</td>
                                    <td class="text-end pe-2">{{ $item->Ingresos_Costo }}</td>
                                    <td class="text-end pe-2">{{ $item->Salidas_Cantidad }}</td>
                                    <td class="text-end pe-2">{{ $item->Salidas_Costo }}</td>
                                    <td class="text-end pe-2">{{ $item->Saldo_Final }}</td>
                                    <td class="text-end pe-2">{{ $item->Costo_Final }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary">
                            @if ($totalGeneral)
                                <tr class="fw-bold text-center">
                                    <td colspan="4">Total General</td>
                                    <td class="text-end pe-2">{{ $totalGeneral->Saldo_Inicial }}</td>
                                    <td class="text-end pe-2">{{ number_format($totalGeneral->Costo_Inicial, 2) }}</td>
                                    <td class="text-end pe-2">{{ $totalGeneral->Ingresos_Cantidad }}</td>
                                    <td class="text-end pe-2">{{ number_format($totalGeneral->Ingresos_Costo, 2) }}</td>
                                    <td class="text-end pe-2">{{ $totalGeneral->Salidas_Cantidad }}</td>
                                    <td class="text-end pe-2">{{ number_format($totalGeneral->Salidas_Costo, 2) }}</td>
                                    <td class="text-end pe-2">{{ $totalGeneral->Saldo_Final }}</td>
                                    <td class="text-end pe-2">{{ number_format($totalGeneral->Costo_Final, 2) }}</td>
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
        flatpickr("#dateFechaInicio, #dateFechaFin", {
            dateFormat: "Y-m-d",
            locale: "es", // Idioma en español
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if (request()->has('fecha_inicio') && request()->has('fecha_fin') && (!isset($productos) || count($productos) === 0))
                Swal.fire({
                    icon: 'info',
                    title: 'Sin productos',
                    text: 'No se encontraron movimientos para el rango de fechas seleccionado.',
                    confirmButtonText: 'Aceptar'
                });
            @endif
        });
    </script>
@endpush
