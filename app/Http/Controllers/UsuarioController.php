<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UsuarioFormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $buscar = trim($request->get('buscar'));
        $usuarios = User::where('name', 'LIKE', '%' . $buscar . '%')
            ->orWhere('ci', 'LIKE', '%' . $buscar . '%')
            ->orderBy('id', 'desc')
            ->paginate(5);
        return view('almacen.usuario.index', compact('usuarios', 'buscar'));
    }

    public function create()
    {
        return view('almacen.usuario.create');
    }

    public function store(UsuarioFormRequest $request)
    {
        try {
            $validated = $request->validated();
            User::create($validated);
            return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al guardar el usuario: " . $e->getMessage());
            return back()->with(['error' => 'Error al guardar el usuario']);
        }
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('almacen.usuario.edit', compact('usuario'));
    }

    public function update(UsuarioFormRequest $request, $id)
    {
        try {
            $usuario = User::findOrFail($id);
            $validated = $request->validated();
            $usuario->update($validated);
            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar el usuario: " . $e->getMessage());
            return back()->with(['error' => 'Error al actualizar el usuario']);
        }
    }

    public function destroy($id)
    {
        try {
            $usuario = User::findOrFail($id);
            $usuario->estado = 0;
            $usuario->save();
            return redirect()->route('usuarios.index')->with('success', 'Usuario desactivado correctamente');
        } catch (\Exception $e) {
            Log::error("Error al desactivar el usuario: " . $e->getMessage());
            return back()->with(['error' => 'Error al desactivar el usuario']);
        }
    }
}
