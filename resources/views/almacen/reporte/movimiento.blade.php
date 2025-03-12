@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Reporte Movimiento</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100 d-flex flex-column">
        <div class="card-header bg-gradient-green">
            <h4 class="text-white my-auto">Movimientos de Inventario</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('movimientos') }}" method="GET">
                @csrf
                <div class="row gap-3">
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
                    <div class="col-md-3 d-flex align-items-center justify-content-around">
                        <button type="submit" class="btn btn-primary btn-labeled">
                            <span class="btn-label"><i class="bi bi-filter-square-fill"></i></span>Filtrar
                        </button>
                        <a href="{{ route('movimientos.imprimir', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')]) }}"
                            target="_blank" class="btn btn-labeled btn-danger">
                            <span class="btn-label"><i class="bi bi-file-pdf-fill"></i></span>Imprimir
                        </a>
                    </div>
                </div>
            </form>
            <div class="table-responsive overflow-auto mt-3">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-secondary">
                        <tr class="text-center align-middle">
                            <th rowspan="2">Código</th>
                            <th rowspan="2">Producto</th>
                            <th rowspan="2">Lote</th>
                            <th rowspan="2">Fecha</th>
                            <th colspan="2">Saldo Inicial</th>
                            <th colspan="2">Ingresos</th>
                            <th colspan="2">Salidas</th>
                            <th colspan="2">Saldo Final</th>
                        </tr>
                        <tr class="text-center">
                            <th>Cant.</th>
                            <th>Valor</th>
                            <th>Cant.</th>
                            <th>Valor</th>
                            <th>Cant.</th>
                            <th>Valor</th>
                            <th>Cant.</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($productos) && count($productos) > 0)
                            @foreach ($productos as $item)
                                <tr>
                                    <td>
                                        <p class="my-1">{{ $item->Codigo }}</p>
                                    </td>
                                    <td>{{ $item->Producto }}</td>
                                    <td>{{ $item->Lote }}</td>
                                    <td>{{ $item->Fecha_Movimiento }}</td>
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
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold text-center">
                            <th colspan="4">TOTAL GENERAL</th>
                            <th class="text-end pe-2">{{ $totalGeneral->Saldo_Inicial ?? 0 }}</th>
                            <th class="text-end pe-2">{{ number_format($totalGeneral->Costo_Inicial ?? 0, 2) }}</th>
                            <th class="text-end pe-2">{{ $totalGeneral->Ingresos_Cantidad ?? 0 }}</th>
                            <th class="text-end pe-2">{{ number_format($totalGeneral->Ingresos_Costo ?? 0, 2) }}</th>
                            <th class="text-end pe-2">{{ $totalGeneral->Salidas_Cantidad ?? 0 }}</th>
                            <th class="text-end pe-2">{{ number_format($totalGeneral->Salidas_Costo ?? 0, 2) }}</th>
                            <th class="text-end pe-2">{{ $totalGeneral->Saldo_Final ?? 0 }}</th>
                            <th class="text-end pe-2">{{ number_format($totalGeneral->Costo_Final ?? 0, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#dateFechaInicio, #dateFechaFin", {
                dateFormat: "Y-m-d",
                locale: "es",
                maxDate: "today",
                minDate: "2025-01-01"
            });
            @if (request()->has('fecha_inicio') && request()->has('fecha_fin') && (!isset($productos) || count($productos) === 0))
                Swal.fire({
                    icon: 'info',
                    title: 'Sin productos',
                    text: 'No se encontraron movimientos para el rango de fechas seleccionado.',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#0b5ed7'
                });
            @endif
        });
    </script>
@endpush
