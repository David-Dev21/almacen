<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\CategoriaFormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $buscar = trim($request->get('buscar'));
        $categorias = Categoria::where('descripcion', 'LIKE', '%' . $buscar . '%')
            ->orderBy('id_categoria', 'desc')
            ->paginate(8);
        return view('almacen.categoria.index', compact('categorias', 'buscar'));
    }

    public function create()
    {
        return view('almacen.categoria.create');
    }

    public function store(CategoriaFormRequest $request)
    {
        try {
            $validated = $request->validated();
            Categoria::create($validated);

            return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al guardar la categoría: " . $e->getMessage());

            return back()->with(['error' => 'Error al guardar la categoría']);
        }
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('almacen.categoria.edit', compact('categoria'));
    }

    public function update(CategoriaFormRequest $request, $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $validated = $request->validated();
            $categoria->update($validated);

            return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar la categoría: " . $e->getMessage());
            return back()->with(['error' => 'Error al actualizar la categoría']);
        }
    }

    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->estado = 0;
            $categoria->save();

            return redirect()->route('categorias.index')->with('success', 'Categoría desactivada correctamente');
        } catch (\Exception $e) {
            Log::error("Error al desactivar la Categoría: " . $e->getMessage());
            return back()->with(['error' => 'Error al desactivar la Categoría']);
        }
    }
}
