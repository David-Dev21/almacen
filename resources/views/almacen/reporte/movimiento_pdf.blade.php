<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Movimientos</title>
    <style>
        /* Force paper size to 13in x 8.5in (oficio landscape) */
        @page { size: 13in 8.5in; margin: 10mm; }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            margin: 0; /* let @page margins apply */
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .header img {
            width: 42px;
            height: auto;
        }

        .table td {
            font-size: 7pt;
            border: solid 1px black;
            text-align: left;
            padding: 4px 6px;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: center;
            font-size: 7pt;
            border: solid 1px black;
            padding: 4px 6px;
        }

        .text-center-top {
            text-align: center;
            vertical-align: top;
        }

        .subtitle th,
        .subtitle td {
            text-align: left;
            font-size: 7pt;
            vertical-align: top;
            padding: 3px 6px;
        }

        .subtitle th {
            width: 12%;
        }

        p {
            font-size: 5.5pt;
            line-height: 1;
            margin: 2px 0;
        }

        .signature {
            text-align: center;
            position: fixed;
            bottom: 2%;
            width: 100%;
        }

        .footer span {
            text-align: right;
            vertical-align: top;
        }


        h2 {
            margin: 0;
            font-size: 12pt;
        }

        .text-right {
            text-align: right !important;
            padding-right: 5px;
        }

        /* Header layout tuned for landscape */
        .header td:first-child {
            width: 14%;
        }

        .header td:nth-child(2) {
            width: 72%;
        }

        .header td:last-child {
            width: 14%;
        }
    </style>
</head>

<body>
    <table class="header">
        <tr class="text-center-top">
            <td width="20%">
                <img src="{{ $logoPath }}" alt="Logo de la entidad"><br>
                <p>POLICIA BOLIVIANA <br> COMANDO DEPARTAMENTAL <br> LA PAZ - BOLIVIA </p>
            </td>
            <td width="60%" class="text-center-top">
                <h2>MOVIMIENTO DE ALMACENES</h2>
                <span>Montos expresados en Bolivianos</span><br>
                <span> Del: {{ $fecha_inicio }} Al: {{ $fecha_fin }}</span>
            </td>
            <td width="20%">
                <div class="footer">
                
            </td>
        </tr>
    </table>
    <!-- Subtítulos -->
    <table class="subtitle">
        <tr>
            <th>Almacén:</th>
            <td>ALMACÉN COMANDO DEPARTAMENTAL LA PAZ</td>
            <th>Fecha de Impresión:</th>
            <td>{{ $fecha_impresion }}</td>
        <tr>
            <th>Fondo:</th>
            <td>Tesoro General de la Nación</td>
        <tr>

        </tr>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">Código</th>
                <th rowspan="2">Producto</th>
                <th rowspan="2">Lote</th>
                <th rowspan="2">Fecha</th>
                <th colspan="2">Saldo Inicial</th>
                <th colspan="2">Ingresos</th>
                <th colspan="2">Salidas</th>
                <th colspan="2">Saldo Final</th>
            </tr>
            <tr>
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
                    <td>{{ $item->Codigo }}</td>
                    <td>{{ $item->Producto }}</td>
                    <td>{{ $item->Lote }}</td>
                    <td>{{ $item->Fecha_Movimiento }}</td>
                    <td class="text-right">{{ $item->Saldo_Inicial }}</td>
                    <td class="text-right">{{ $item->Costo_Inicial }}</td>
                    <td class="text-right">{{ $item->Ingresos_Cantidad }}</td>
                    <td class="text-right">{{ $item->Ingresos_Costo }}</td>
                    <td class="text-right">{{ $item->Salidas_Cantidad }}</td>
                    <td class="text-right">{{ $item->Salidas_Costo }}</td>
                    <td class="text-right">{{ $item->Saldo_Final }}</td>
                    <td class="text-right">{{ $item->Costo_Final }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="table">
            <tr>
                <th colspan="4">TOTAL GENERAL</th>
                <th class="text-right">{{ $totalGeneral->Saldo_Inicial }}</th>
                <th class="text-right">{{ number_format($totalGeneral->Costo_Inicial, 2) }}</th>
                <th class="text-right">{{ $totalGeneral->Ingresos_Cantidad }}</th>
                <th class="text-right">{{ number_format($totalGeneral->Ingresos_Costo, 2) }}</th>
                <th class="text-right">{{ $totalGeneral->Salidas_Cantidad }}</th>
                <th class="text-right">{{ number_format($totalGeneral->Salidas_Costo, 2) }}</th>
                <th class="text-right">{{ $totalGeneral->Saldo_Final }}</th>
                <th class="text-right">{{ number_format($totalGeneral->Costo_Final, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
