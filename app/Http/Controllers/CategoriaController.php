<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Mostrar todas las categorías.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Mostrar formulario para crear nueva categoría.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Guardar una nueva categoría.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ]);

        Categoria::create($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Mostrar una categoría (opcional).
     */
    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Mostrar formulario para editar una categoría.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualizar una categoría existente.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
        ]);

        $categoria->update($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Eliminar una categoría.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
