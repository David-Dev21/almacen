<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ingreso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header img {
            width: 50px;
            height: auto;
        }

        .table td {
            font-size: 8pt;
            border: solid 1px black;
            text-align: left;
            padding-left: 10px;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: center;
            font-size: 8pt;
            border: solid 1px black;

        }

        .text-center-top {
            text-align: center;
            vertical-align: top;
        }

        .subtitle th,
        .subtitle td {
            text-align: left;
            font-size: 8pt;
        }

        .subtitle th {
            width: 10%;
            vertical-align: top;
        }

        p {
            font-size: 5pt;
            line-height: 1;
        }

        .signature {
            text-align: center;
            margin-top: 80px;
            page-break-inside: avoid;
        }

        h2 {
            margin: 0;
        }

        .text-right {
            text-align: right !important;
            padding-right: 15px;
        }
    </style>
</head>

<body>
    <table class="header">
        <tr class="text-center-top">
            <td width="20%">
                <img src="{{ $logoPath }}" alt="Logo de la entidad"><br>
                <p> POLICIA BOLIVIANA <br> COMANDO DEPARTAMENTAL <br> LA PAZ - BOLIVIA </p>
            </td>
            <td width="60%">
                <h2>RECEPCIÓN DE PRODUCTOS</h2>
                <span>Montos expresados en Bolivianos</span>
            </td>
            <td width="20%">
                <div class="footer">
                    <span class="page-number"></span>
                </div>
            </td>
        </tr>
    </table>

    <!-- Subtítulos -->
    <table class="subtitle">
        <tr>
            <th>Entidad:</th>
            <td>COMANDO DEPARTAMENTAL LA PAZ</td>
            <th>Proveedor:</th>
            <td>{{ $ingreso->nombre_proveedor }}</td>
        </tr>
        <tr>
            <th>Fondo:</th>
            <td>Tesoro General de la Nación</td>
            <th>Tipo:</th>
            <td>Ingreso (Compra)</td>

        </tr>
        <tr>
            <th>Almacén:</th>
            <td>ALMACÉN COMANDO DEPARTAMENTAL</td>
            <th>Nº Factura:</th>
            <td>{{ $ingreso->n_factura }}</td>
        </tr>
        <tr>
            <th>Nº Ingreso:</th>
            <td>{{ $ingreso->id_ingreso }}</td>
            <th>Fecha:</th>
            <td>{{ $fecha }}</td>
        </tr>
        <tr>
            <th>Glosa:</th>
            <td colspan="3">
                RECEPCIÓN DE
                @foreach ($categorias as $categoria)
                    {{ $loop->first ? '' : ', ' }}{{ $categoria }}
                @endforeach
                SEGÚN FACTURA Nº {{ $ingreso->n_factura }} Y PEDIDO Nº {{ $ingreso->n_pedido }}. 
                SE FIRMA EL PRESENTE ACTA EN CONSTANCIA DE LA RECEPCIÓN CONFORME A ESPECIFICACIONES TÉCNICAS.
            </td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Unidad</th>
                <th>Lote</th>
                <th>Cantidad</th>
                <th>Costo <br> Unitario</th>
                <th>Costo <br> Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $categoriaActual = null;
                $totalCantidadOriginal = 0;
                $totalCantidadDisponible = 0;
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
                        <td><strong>{{ $codigoCategoria }}</strong></td>
                        <td colspan="6"><strong>{{ $categoriaActual }}</strong></td>
                    </tr>
                @endif
                <tr>
                    <td>{{ $item->codigo_producto }}</td>
                    <td>{{ $item->producto }}</td>
                    <td>{{ $item->unidad }}</td>
                    <td>{{ $item->lote }}</td>
                    <td class="text-right">{{ $item->cantidad_original }}</td>
                    <td class="text-right">{{ number_format($item->costo_u, 2) }}</td>
                    <td class="text-right">{{ number_format($item->cantidad_original * $item->costo_u, 2) }}</td>
                </tr>
                @php
                    $totalCantidadOriginal += $item->cantidad_original;
                    $totalCantidadDisponible += $item->cantidad_disponible;
                    $totalCostoUnitario += $item->costo_u;
                    $totalCostoTotal += $item->cantidad_original * $item->costo_u;
                @endphp
            @endforeach
        </tbody>
        <tfoot class="table">
            <tr>
                <th colspan="4">TOTAL GENERAL</th>
                <th class="text-right">{{ $totalCantidadOriginal }}</th>
                <th class="text-right">{{ number_format($totalCostoUnitario, 2) }}</th>
                <th class="text-right">{{ number_format($totalCostoTotal, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <!-- signature block: allow it to flow onto the previous page if there is space -->
    <table class="signature" style="width:100%;">
        <tr>
            <td>Encargado de Almacén</td>
            <td>Jefe Financiero</td>
            <td>Jefe Administrativo</td>
        </tr>
    </table>
</body>

</html>
