<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalidaFormRequest;
use App\Models\DetalleSalida;
use App\Models\Salida;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SalidaController extends Controller
{
    public function __construct() {}
    // public function __construct()
    // {
    //     $this->middleware('auth'); // Ensure the user is authenticated
    // }

    //
    public function index(Request $request)
    {
        $buscar = trim($request->get('buscar'));

        // Utilizando la vista creada en la base de datos
        $salidas = DB::table('vista_salidas')
            ->where('n_hoja_ruta', 'LIKE', '%' . $buscar . '%')
            ->paginate(8);

        return view('almacen.salida.index', compact('salidas', 'buscar'));
    }

    public function create()
    {
        // Utilizando modelos para obtener los datos
        $unidades = Unidad::all()->where('estado', '=', '1');
        $productos = DB::select("select p.id_producto,concat(di.lote, ' | ',p.descripcion ,' | ',di.cantidad_disponible) AS producto_lote, p.stock, di.lote, di.cantidad_disponible, di.costo_u from productos p inner join detalle_ingresos di on p.id_producto = di.id_producto where p.stock > 0 and di.cantidad_disponible > 0 and p.estado = 1;");
        return view('almacen.salida.create', compact("unidades", "productos"));
    }

    public function store(SalidaFormRequest $request)
    {
        try {
            $validated = $request->validated();
            DB::beginTransaction();

            // Crear nuevo salida
            $salida = new Salida();
            $salida->id_unidad = $validated['id_unidad'];
            $salida->id_usuario = Auth::id(); // Obtener el ID del usuario autenticado
            $salida->n_hoja_ruta = $validated['n_hoja_ruta'];
            $salida->n_pedido = $validated['n_pedido'];
            $salida->estado = 'completado';
            $salida->fecha_hora = Carbon::now('America/La_Paz')->toDateTimeString();
            $salida->total = 0;
            $salida->save();

            // Obtener los datos de los productos
            $id_producto = $request->input('id_producto', []);
            $cantidad = $request->input('cantidad', []);
            $total = 0;

            // Iterar sobre los productos y guardar los detalles de salida
            for ($cont = 0; $cont < count($id_producto); $cont++) {
                // Obtener el detalle del ingreso correspondiente al producto con suficiente cantidad disponible
                $detalle_ingreso = DB::table('detalle_ingresos')
                    ->where('id_producto', $id_producto[$cont])
                    ->where('cantidad_disponible', '>=', $cantidad[$cont])
                    ->select('id_producto', 'costo_u', 'lote')
                    ->first();

                if ($detalle_ingreso) {
                    // Crear detalle de salida
                    $detalle = new DetalleSalida();
                    $detalle->id_salida = $salida->id_salida;
                    $detalle->id_producto = $id_producto[$cont];
                    $detalle->cantidad = $cantidad[$cont];
                    $detalle->costo_u = $detalle_ingreso->costo_u; // Usar el costo del detalle_ingreso
                    $detalle->lote = $detalle_ingreso->lote;
                    $detalle->save();

                    // Restar la cantidad del detalle de ingreso
                    DB::table('detalle_ingresos')
                        ->where('id_producto', $detalle_ingreso->id_producto)
                        ->where('lote', $detalle_ingreso->lote)
                        ->decrement('cantidad_disponible', $cantidad[$cont]);

                    // Calcular el total
                    $total += $cantidad[$cont] * $detalle_ingreso->costo_u;
                } else {
                    // Manejar el caso en que no hay suficiente cantidad disponible
                    DB::rollBack();
                    return back()->with(['error' => 'No hay suficiente cantidad disponible para el producto especificado.']);
                }
            }

            // Actualizar el total del salida
            $salida->total = $total;
            $salida->save();

            DB::commit();

            // Redirigir después de guardar
            return redirect()->route('salidas.index')->with('success', 'Salida registrada exitosamente');
        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje
            DB::rollBack();
            Log::error("Error al registrar la salida: " . $e->getMessage());
            return back()->with(['error' => 'Error al registrar la salida']);
        }
    }

    //
    public function show($id)
    {
        // Obtener los detalles del salida desde la vista
        $salida = DB::table('vista_salidas')
            ->where('id_salida', '=', $id)
            ->first();

        // Obtener los detalles de los productos del salida
        $detalles = DB::table('vista_detalle_salidas_con_categorias')
            ->where('id_salida', $id)
            ->get();

        // Devolver la vista con los datos del salida y los detalles
        return view('almacen.salida.show', compact("salida", "detalles"));
    }

    public function edit(string $id) {}

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
    {
        try {
            // Obtener el salida por ID
            $salida = Salida::findOrFail($id);

            // Marcar el estado del salida como 0 (Cancelado)
            $salida->estado = 0;
            $salida->save();

            // Redirigir después de actualizar el estado
            return redirect()->route('salidas.index')->with('success', 'Salida cancelada exitosamente');
        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje
            Log::error("Error al cancelar la salida: " . $e->getMessage());
            return back()->with(['error' => 'Error al cancelar la salida']);
        }
    }
}
