<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoFormRequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return view('almacen.producto.index', compact('productos'));
    }

    // Método para mostrar el formulario de creación de productos
    public function create()
    {
        $categorias = Categoria::where('estado', '=', '1')->get();
        return view('almacen.producto.create', compact('categorias'));
    }

    // Método para guardar un nuevo producto
    public function store(ProductoFormRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['estado'] = 1;
            $producto = new Producto($validated);

            // Guardar el nuevo producto en la base de datos
            $producto->save();

            // Redirigir después de guardar
            return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje
            Log::error("Error al crear el producto: " . $e->getMessage());
            return redirect()->route('productos.index')->with(['error' => 'Error al crear el producto']);
        }
    }

    // Método para mostrar el formulario de edición de productos
    public function edit($id)
    {
        $categorias = Categoria::where('estado', '=', '1')->get();
        $producto = Producto::findOrFail($id);
        return view('almacen.producto.edit', compact('producto', 'categorias'));
    }

    // Método para actualizar un producto existente
    public function update(ProductoFormRequest $request, string $id)
    {
        try {
            // Encontrar el producto por su ID
            $producto = Producto::findOrFail($id);
            $validated = $request->validated();
            $producto->fill($validated);

            // Guardar los cambios en la base de datos
            $producto->save();

            // Redirigir después de guardar
            return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje
            Log::error("Error al actualizar el producto: " . $e->getMessage());
            return redirect()->route('productos.index')->with(['error' => 'Error al actualizar el producto']);
        }
    }

    public function generarCodigo($id_categoria)
    {
        // Encontrar la categoría por ID
        $categoria = Categoria::find($id_categoria);
        if (!$categoria) {
            return response()->json(['codigo' => ''], 404);
        }

        // Obtener el código de la categoría
        $categoriaCodigo = $categoria->codigo;

        // Buscar el último producto de la categoría ordenado por su código en orden descendente
        $ultimoProducto = Producto::where('id_categoria', $id_categoria)
            ->orderByRaw('CAST(SUBSTRING_INDEX(codigo, "-", -1) AS UNSIGNED) DESC')
            ->first();

        // Definir el nuevo número como 1 por defecto
        $nuevoNumero = 1;

        // Si hay un último producto, extraer el número y sumar 1
        if ($ultimoProducto) {
            $ultimoCodigo = $ultimoProducto->codigo;
            $partesCodigo = explode('-', $ultimoCodigo);
            if (count($partesCodigo) == 2 && is_numeric($partesCodigo[1])) {
                $nuevoNumero = intval($partesCodigo[1]) + 1;
            }
        }

        // Generar el nuevo código con el número incrementado
        $codigo = $categoriaCodigo . '-' . str_pad($nuevoNumero, 5, '0', STR_PAD_LEFT);

        // Retornar el código generado en una respuesta JSON
        return response()->json(['codigo' => $codigo]);
    }

    public function toggleEstado(Request $request, $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->estado = $request->estado;
            $producto->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error al cambiar el estado del producto: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al cambiar el estado del producto']);
        }
    }
}
