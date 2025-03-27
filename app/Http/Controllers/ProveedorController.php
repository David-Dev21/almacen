<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorFormRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProveedorController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $proveedores = Proveedor::all();
        return view('almacen.proveedor.index', compact('proveedores'));
    }

    public function create()
    {
        return view('almacen.proveedor.create');
    }

    public function store(ProveedorFormRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['estado'] = 1;
            Proveedor::create($validated);
            return redirect()->route('proveedores.index')->with('success', 'Proveedor guardado correctamente');
        } catch (\Exception $e) {
            Log::error("Error al guardar el Proveedor: " . $e->getMessage());
            return redirect()->route('proveedores.index')->with(['error' => 'Error al guardar el Proveedor']);
        }
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('almacen.proveedor.edit', compact('proveedor'));
    }

    public function update(ProveedorFormRequest $request, $id)
    {
        try {
            $categoria = Proveedor::findOrFail($id);
            $validated = $request->validated();
            $categoria->update($validated);
            return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente');
        } catch (\Exception $e) {
            Log::error("Error al actualizar el Proveedor: " . $e->getMessage());
            return redirect()->route('proveedores.index')->with(['error' => 'Error al actualizar el Proveedor']);
        }
    }

    public function toggleEstado(Request $request, $id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->estado = $request->estado;
            $proveedor->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error al cambiar el estado del proveedor: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al cambiar el estado del proveedor']);
        }
    }
}
