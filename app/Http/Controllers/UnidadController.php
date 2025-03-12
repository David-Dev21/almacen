<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadFormRequest;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnidadController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $buscar = trim($request->get('buscar'));
        $unidades = Unidad::where('nombre', 'LIKE', '%' . $buscar . '%')
            ->orderBy('id_unidad', 'desc')
            ->paginate(10);
        return view('almacen.unidad.index', compact('unidades', 'buscar'));
    }

    public function create()
    {
        return view('almacen.unidad.create');
    }

    public function store(UnidadFormRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['estado'] = 1;
            Unidad::create($validated);
            return redirect()->route('unidades.index')->with('success', 'Unidad creada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al guardar la unidad: " . $e->getMessage());
            return redirect()->route('unidades.index')->with(['error' => 'Error al guardar la unidad']);
        }
    }

    public function edit($id)
    {
        $unidad = Unidad::findOrFail($id);
        return view('almacen.unidad.edit', compact('unidad'));
    }

    public function update(UnidadFormRequest $request, $id)
    {
        try {
            $unidad = Unidad::findOrFail($id);
            $validated = $request->validated();
            $unidad->update($validated);
            return redirect()->route('unidades.index')->with('success', 'Unidad actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar la unidad: " . $e->getMessage());
            return redirect()->route('unidades.index')->with(['error' => 'Error al actualizar la unidad']);
        }
    }

    public function toggleEstado(Request $request, $id)
    {
        try {
            $unidad = Unidad::findOrFail($id);
            $unidad->estado = $request->estado;
            $unidad->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error al cambiar el estado de la unidad: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al cambiar el estado de la unidad']);
        }
    }
}
