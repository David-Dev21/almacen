<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngresoFormRequest;
use App\Models\DetalleIngreso;
use App\Models\Ingreso;
use App\Models\Producto;
use App\Models\Proveedor;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;



class IngresoController extends Controller
{
    //
    public function __construct() {}

    //
    public function index(Request $request)
    {
        $buscar = trim($request->get('buscar'));

        // Utilizando la vista creada en la base de datos
        $ingresos = DB::table('vista_ingresos')
            ->where('n_factura', 'LIKE', '%' . $buscar . '%')
            ->paginate(8);

        return view('almacen.ingreso.index', compact('ingresos', 'buscar'));
    }

    public function create()
    {
        // Utilizando modelos para obtener los datos
        $proveedores = Proveedor::all()->where('estado', '=', '1');
        $productos = Producto::where('estado', '=', '1')
            ->select('id_producto', 'descripcion')
            ->get();

        return view('almacen.ingreso.create', compact("proveedores", "productos"));
    }

    public function store(IngresoFormRequest $request)
    {
        try {
            $validated = $request->validated();

            DB::beginTransaction();

            // Crear nuevo ingreso
            $ingreso = new Ingreso();
            $ingreso->id_proveedor = $validated['id_proveedor'];
            $ingreso->id_usuario = Auth::id(); // Obtener el ID del usuario autenticado
            $ingreso->n_factura = $validated['n_factura'];
            $ingreso->estado = 'completado';
            $ingreso->fecha_hora = Carbon::now('America/La_Paz')->toDateTimeString();
            $ingreso->total = 0; // Inicializa total a 0, lo calculamos después
            $ingreso->save();

            // Obtener los datos de los productos
            $idProducto = $request->input('id_producto', []);
            $cantidad = $request->input('cantidad_original', []);
            $precio_u = $request->input('costo_u', []);
            $lote = $request->input('lote', ''); // Obtener el lote del request
            $total = 0;

            // Verificar que $idProducto es un array y no está vacío
            if (is_array($idProducto) && count($idProducto) > 0) {
                // Iterar sobre los productos y guardar los detalles de ingreso
                for ($cont = 0; $cont < count($idProducto); $cont++) {
                    $detalle = new DetalleIngreso();
                    $detalle->id_ingreso = $ingreso->id_ingreso; // Asegúrate de que esta propiedad existe y es correcta
                    $detalle->id_producto = $idProducto[$cont];
                    $detalle->cantidad_original = $cantidad[$cont];
                    $detalle->cantidad_disponible = $cantidad[$cont];
                    $detalle->costo_u = $precio_u[$cont];
                    $detalle->lote = $lote; // Usar el mismo lote para cada detalle
                    $detalle->save();

                    // Calcular el total
                    $total += $cantidad[$cont] * $precio_u[$cont];
                }

                // Actualizar el total del ingreso
                $ingreso->total = $total;
                $ingreso->save();
            } else {
                // Manejar el caso en que $idProducto no es un array o está vacío
                return back()->with(['error' => 'No se proporcionaron productos válidos.']);
            }

            DB::commit();

            // Redirigir después de guardar
            return redirect()->route('ingresos.index')->with('success', 'Ingreso registrado exitosamente');
        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje
            DB::rollBack();
            Log::error("Error al registrar el ingreso: " . $e->getMessage());
            return back()->with(['error' => 'Error al registrar el ingreso']);
        }
    }


    //
    public function show($id)
    {
        // Obtener los detalles del ingreso desde la vista
        $ingresos = DB::table('vista_ingresos')
            ->where('id_ingreso', '=', $id)
            ->first();

        // Obtener los detalles de los productos del ingreso
        $detalles = DB::table('detalle_ingresos as d')
            ->join('productos as p', 'd.id_producto', '=', 'p.id_producto')
            ->select('p.descripcion as producto', 'd.cantidad_original', 'd.costo_u')
            ->where('d.id_ingreso', '=', $id)
            ->get();

        // Devolver la vista con los datos del ingreso y los detalles
        return view('almacen.ingreso.show', compact("ingresos", "detalles"));
    }

    public function edit(string $id)
    {
        //
    }

    //
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
    {
        try {
            // Obtener el ingreso por ID
            $ingreso = Ingreso::findOrFail($id);

            // Marcar el estado del ingreso como 0 (Cancelado)
            $ingreso->estado = 0;
            $ingreso->save();

            // Redirigir después de actualizar el estado
            return redirect()->route('ingresos.index')->with('success', 'Ingreso cancelado exitosamente');
        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje
            Log::error("Error al cancelar el ingreso: " . $e->getMessage());
            return back()->with(['error' => 'Error al cancelar el ingreso']);
        }
    }
}
