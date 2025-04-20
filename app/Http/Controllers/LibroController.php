<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Categoria;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Mostrar todos los libros.
     */
    public function index()
    {
        $libros = Libro::with('categoria')->get();
        return view('libros.index', compact('libros'));
    }

    /**
     * Mostrar formulario para crear un nuevo libro.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('libros.create', compact('categorias'));
    }

    /**
     * Guardar un nuevo libro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'editorial' => 'nullable|string|max:255',
            'anio' => 'nullable|numeric',
            'estado' => 'required|in:disponible,prestado,reservado',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Libro::create($request->all());

        return redirect()->route('libros.index')->with('success', 'Libro creado correctamente.');
    }

    /**
     * Mostrar un solo libro (opcional).
     */
    public function show(Libro $libro)
    {
        return view('libros.show', compact('libro'));
    }

    /**
     * Mostrar formulario para editar un libro.
     */
    public function edit(Libro $libro)
    {
        $categorias = Categoria::all();
        return view('libros.edit', compact('libro', 'categorias'));
    }

    /**
     * Actualizar un libro.
     */
    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'editorial' => 'nullable|string|max:255',
            'anio' => 'nullable|numeric',
            'estado' => 'required|in:disponible,prestado,reservado',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $libro->update($request->all());

        return redirect()->route('libros.index')->with('success', 'Libro actualizado correctamente.');
    }

    /**
     * Eliminar un libro.
     */
    public function destroy(Libro $libro)
    {
        $libro->delete();
        return redirect()->route('libros.index')->with('success', 'Libro eliminado correctamente.');
    }
}
