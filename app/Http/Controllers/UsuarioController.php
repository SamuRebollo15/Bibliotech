<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Mostrar todos los usuarios (solo admin).
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Mostrar formulario para crear usuario (opcional).
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Guardar nuevo usuario (opcional).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios',
            'password' => 'required|min:6|confirmed',
            'rol' => 'required|in:admin,lector',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar un usuario (opcional).
     */
    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Actualizar un usuario.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo,' . $usuario->id,
            'rol' => 'required|in:admin,lector',
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'rol' => $request->rol,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
