<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use TCPDF;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function generarPDF($id)
    {
        // Crear un nuevo PDF
        $pdf = new TCPDF();

        // Configurar documento
        $pdf->SetCreator('Laravel TCPDF');
        $pdf->SetAuthor('Tu Nombre');
        $pdf->SetTitle('Reporte de Productos');
        $pdf->SetSubject('Listado de Productos');
        $pdf->SetKeywords('Laravel, TCPDF, Reporte, PDF');

        // Obtener los detalles del salida desde la vista
        $salida = DB::table('vista_salidas')
            ->where('id_salida', '=', $id)
            ->first();

        // Agregar página con orientación y tamaño (P=Vertical, L=Horizontal, A4)
        $pdf->AddPage('P', 'A4');

        // Cabecera personalizada
        $imageFile = public_path('img/logo-policia.png');
        if (file_exists($imageFile)) {
            $pdf->Image($imageFile, 10, 10, 30); // (ruta, x, y, ancho)
        }

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'ENTREGA DE PRODUCTOS', 0, 0, 'C');

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetY(25);

        // Primera fila de subtítulos
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(18, 6, 'Entidad:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(80, 6, 'COMANDO DEPARTAMENTAL LA PAZ', 0, 0, 'L');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(18, 6, 'Fecha:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(40, 6, Carbon::now('America/La_Paz')->format('d/m/Y'), 0, 1, 'L');

        // Segunda fila de subtítulos
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(18, 6, 'Fondo:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(80, 6, 'Tesoro General de la Nación', 0, 0, 'L');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(18, 6, 'Cliente:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(40, 6, $salida->nombre_unidad, 0, 1, 'L');

        // Tercera fila de subtítulos
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(18, 6, 'Almacén:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(80, 6, 'ALMACÉN COMANDO DEPARTAMENTAL', 0, 1, 'L');

        // Cuarta fila de subtítulos
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(18, 6, 'Clase:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(80, 6, 'Egreso (Pedido)', 0, 0, 'L');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(18, 6, 'Pedido:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(40, 6, $salida->n_pedido, 0, 1, 'L');

        // Quinta fila de subtítulos
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(18, 6, 'Número:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(40, 6, '000106', 0, 1, 'L');

        // Glosa
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(18, 6, 'Glosa:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(0, 6, 'ENTREGA DE MATERIAL DE ESCRITORIO, PAPELERÍA Y LIMPIEZA, SEGÚN STOCK DE ALMACENES, ENCONSTANCIA SE FIRMA AL PIE DEL PRESENTE ACTA DE ENTREGA, EN CUMPLIMIENTO A LA HOJA DE RUTA,' . $salida->n_hoja_ruta, 0, 'L');

        // Obtener los detalles de los productos del salida
        $detalles = DB::table('detalle_salidas as d')
            ->join('productos as p', 'd.id_producto', '=', 'p.id_producto')
            ->select('p.codigo', 'p.descripcion as producto', 'p.unidad', 'd.cantidad', 'd.costo_u', 'd.lote')
            ->where('d.id_salida', '=', $id)
            ->get();

        // Verificar si se obtienen productos
        if ($detalles->isEmpty()) {
            $pdf->Cell(0, 10, 'No hay productos disponibles.', 0, 1, 'C');
        } else {
            // Posicionarse en la tabla
            $pdf->SetY(70); // Ajustar la posición Y para evitar superposición con la cabecera
            $pdf->SetFont('helvetica', '', 10);

            // Crear la tabla
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(10, 10, 'No', 1, 0, 'C');
            $pdf->Cell(20, 10, 'Item', 1, 0, 'C');
            $pdf->Cell(60, 10, 'Producto', 1, 0, 'C');
            $pdf->Cell(20, 10, 'Unidad', 1, 0, 'C');
            $pdf->Cell(20, 10, 'Lote', 1, 0, 'C');
            $pdf->Cell(20, 10, 'Cantidad', 1, 0, 'C');
            $pdf->MultiCell(20, 10, "Costo\nUnitario", 1, 'C', 0, 0);
            $pdf->MultiCell(20, 10, "Costo\nTotal", 1, 'C', 0, 1);

            $pdf->SetFont('helvetica', '', 10);
            foreach ($detalles as $index => $item) {
                $pdf->Cell(10, 10, $index + 1, 1, 0, 'C');
                $pdf->Cell(20, 10, $item->codigo, 1, 0, 'C');
                $pdf->MultiCell(60, 10, $item->producto, 1, 'C', 0, 0);
                $pdf->Cell(20, 10, $item->unidad, 1, 0, 'C');
                $pdf->Cell(20, 10, $item->lote, 1, 0, 'C');
                $pdf->Cell(20, 10, $item->cantidad, 1, 0, 'C');
                $pdf->Cell(20, 10, number_format($item->costo_u, 2), 1, 0, 'C');
                $pdf->Cell(20, 10, number_format($item->cantidad * $item->costo_u, 2), 1, 1, 'C');
            }
        }

        // Pie de página personalizado
        $pdf->SetY(-20);
        $pdf->SetFont('helvetica', 'I', 8);
        $pdf->Cell(0, 10, 'Página ' . $pdf->getAliasNumPage() . ' de ' . $pdf->getAliasNbPages(), 0, 0, 'C');

        // Salida del PDF
        return response($pdf->Output('reporte_salida_' . $id . '.pdf', 'S'))
            ->header('Content-Type', 'application/pdf');
    }
}
