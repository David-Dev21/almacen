<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorFormRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProveedorController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $buscar = trim($request->get('buscar'));
        $proveedores = Proveedor::where('nombre', 'LIKE', '%' . $buscar . '%')
            ->orderBy('id_proveedor', 'desc')
            ->paginate(5);
        return view('almacen.proveedor.index', compact('proveedores', 'buscar'));
    }

    public function create()
    {
        return view('almacen.proveedor.create');
    }

    public function store(ProveedorFormRequest $request)
    {
        try {
            $validated = $request->validated();
            Proveedor::create($validated);
            return redirect()->route('proveedores.index')->with('success', 'Proveedor guardado correctamente');
        } catch (\Exception $e) {
            Log::error("Error al guardar el Proveedor: " . $e->getMessage());
            return back()
                ->with(['error' => 'Error al guardar la proveedor']);
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
            return back()->with(['error' => 'Error al actualizar el Proveedor']);
        }
    }

    public function destroy($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->estado = 0;
            $proveedor->save();
            return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente');
        } catch (\Exception $e) {
            Log::error("Error al eliminar el Proveedor: " . $e->getMessage());
            return back()->with(['msg' => 'Error al eliminar el Proveedor']);
        }
    }
}
