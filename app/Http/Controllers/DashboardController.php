<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Ingreso;
use App\Models\Salida;
use App\Models\Categoria;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch data from the database
        $totalProductos = Producto::count();
        $totalIngresos = Ingreso::count();
        $totalSalidas = Salida::count();
        $productosPorCategoria = Categoria::withCount('productos')->get();
        $ultimaSalida = Salida::latest()->first();
        $ultimoIngreso = Ingreso::latest()->first();
        $fecha = Carbon::now()->format('Y-m-d');
        // Obtener la cantidad de salidas por mes
        $salidasPorMes = Salida::select(
            DB::raw('YEAR(fecha_hora) as year'),
            DB::raw('MONTH(fecha_hora) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc') // Corregido, ahora se especifica la dirección
            ->orderBy('month', 'asc') // Corregido, ahora se especifica la dirección
            ->get();

        return view('almacen.dashboard', compact(
            'totalProductos',
            'totalIngresos',
            'totalSalidas',
            'productosPorCategoria',
            'ultimaSalida',
            'ultimoIngreso',
            'fecha',
            'salidasPorMes'

        ));
    }
}
