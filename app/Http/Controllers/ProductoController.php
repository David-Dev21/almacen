<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoFormRequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    // Constructor del controlador
    public function __construct() {}

    // Método para listar los productos
    public function index(Request $request)
    {
        // Obtener y limpiar el texto de búsqueda
        $buscar = trim($request->get('buscar'));
        // Consulta para recuperar productos junto con sus categorías
        $productos = Producto::with('categoria')
            ->where('descripcion', 'LIKE', '%' . $buscar . '%')
            ->orderBy('id_producto', 'desc')
            ->paginate(8);

        $categorias = Categoria::where('estado', '=', '1')->get();
        // Retornar la vista con los productos y el texto de búsqueda
        return view('almacen.producto.index', compact('productos', 'buscar', 'categorias'));
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
            $producto = new Producto($validated);

            // Manejo de la imagen
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = Str::slug($request->descripcion) . '.' . $imagen->getClientOriginalExtension();
                $ruta = public_path('imagenes/productos/');

                // Crear el directorio si no existe
                if (!file_exists($ruta)) {
                    mkdir($ruta, 0777, true);
                }

                // Mover la imagen al directorio
                $imagen->move($ruta, $nombreImagen);
                $producto->imagen = $nombreImagen;
            }

            // Guardar el nuevo producto en la base de datos
            $producto->save();

            // Redirigir después de guardar
            return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje
            Log::error("Error al crear el producto: " . $e->getMessage());
            return back()->with(['error' => 'Error al crear el producto']);
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

            // Manejo de la imagen
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = Str::slug($request->descripcion) . '.' . $imagen->getClientOriginalExtension();
                $ruta = public_path('imagenes/productos/');

                // Crear el directorio si no existe
                if (!file_exists($ruta)) {
                    mkdir($ruta, 0777, true);
                }

                // Mover la imagen al directorio
                $imagen->move($ruta, $nombreImagen);
                $producto->imagen = $nombreImagen;
            }

            // Guardar los cambios en la base de datos
            $producto->save();

            // Redirigir después de guardar
            return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje
            Log::error("Error al actualizar el producto: " . $e->getMessage());
            return back()->with(['error' => 'Error al actualizar el producto']);
        }
    }

    // Método para eliminar (desactivar) un producto
    public function destroy(string $id)
    {
        try {
            //Encontrar por su ID
            $producto = Producto::findOrFail($id);
            $producto->estado = 0;
            $producto->save();
            // Redirigir a la lista
            return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente');
        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje
            Log::error("Error al eliminar el producto: " . $e->getMessage());
            return back()->with(['error' => 'Error al eliminar el producto']);
        }
    }
}
