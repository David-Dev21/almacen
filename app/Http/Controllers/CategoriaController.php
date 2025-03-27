<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\CategoriaFormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $categorias = Categoria::all();
        return view('almacen.categoria.index', compact('categorias'));
    }

    public function create()
    {
        return view('almacen.categoria.create');
    }

    public function store(CategoriaFormRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['estado'] = 1;
            Categoria::create($validated);

            return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al guardar la categoría: " . $e->getMessage());
            return redirect()->route('categorias.index')->with(['error' => 'Error al guardar la categoría']);
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
            return redirect()->route('categorias.index')->with(['error' => 'Error al actualizar la categoría']);
        }
    }

    public function toggleEstado(Request $request, $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->estado = $request->estado;
            $categoria->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error al cambiar el estado de la categoría: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al cambiar el estado de la categoría']);
        }
    }
}
