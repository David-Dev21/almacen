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
            ->paginate(5);
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
            Unidad::create($validated);
            return redirect()->route('unidades.index')->with('success', 'Unidad guardado correctamente');
        } catch (\Exception $e) {
            Log::error("Error al guardar la Unidad:" . $e->getMessage());
            return back()->with(['error' => 'Error al guardar la Unidad']);
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
            return redirect()->route('unidades.index')->with('success', 'Unidad actualizado correctamente');
        } catch (\Exception $e) {
            Log::error("Error al actualizar la Unidad: " . $e->getMessage());
            return back()->with(['error' => 'Error al actualizar la Unidad']);
        }
    }

    public function destroy($id)
    {
        try {
            $unidad = Unidad::findOrFail($id);
            $unidad->estado = 0;
            $unidad->save();
            return redirect()->route('unidades.index')->with('success', 'Unidad eliminado correctamente');
        } catch (\Exception $e) {
            Log::error("Error al eliminar la Unidad: " . $e->getMessage());
            return back()->with(['error' => 'Error al eliminar la Unidad']);
        }
    }
}
