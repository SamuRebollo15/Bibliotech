<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Categoria;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Muestra todos los libros con búsqueda (incluye título en inglés).
     */
    public function index(Request $request)
    {
        $query = Libro::query();

        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');

            $query->where(function ($q) use ($busqueda) {
                $q->where('titulo', 'like', "%{$busqueda}%")
                  ->orWhere('titulo_en', 'like', "%{$busqueda}%")
                  ->orWhere('autor', 'like', "%{$busqueda}%");
                // Si quieres, también podrías incluir sinopsis:
                // ->orWhere('sinopsis', 'like', "%{$busqueda}%")
                // ->orWhere('sinopsis_en', 'like', "%{$busqueda}%");
            });
        }

        $libros = $query->with('categoria')->get();

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
     * Guardar un nuevo libro (incluye campos en inglés).
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'titulo_en'    => 'nullable|string|max:255',
            'autor'        => 'nullable|string|max:255',
            'editorial'    => 'nullable|string|max:255',
            'anio'         => 'nullable|numeric',
            'estado'       => 'required|in:disponible,prestado,reservado',
            'categoria_id' => 'required|exists:categorias,id',
            'sinopsis'     => 'nullable|string',
            'sinopsis_en'  => 'nullable|string',
        ]);

        Libro::create($request->only([
            'titulo',
            'titulo_en',
            'autor',
            'editorial',
            'anio',
            'estado',
            'categoria_id',
            'sinopsis',
            'sinopsis_en',
        ]));

        return redirect()->route('libros.index')->with('success', __('Libro creado correctamente.'));
    }

    /**
     * Mostrar un solo libro.
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
     * Actualizar un libro (incluye campos en inglés).
     */
    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'titulo_en'    => 'nullable|string|max:255',
            'autor'        => 'nullable|string|max:255',
            'editorial'    => 'nullable|string|max:255',
            'anio'         => 'nullable|numeric',
            'estado'       => 'required|in:disponible,prestado,reservado',
            'categoria_id' => 'required|exists:categorias,id',
            'sinopsis'     => 'nullable|string',
            'sinopsis_en'  => 'nullable|string',
        ]);

        $libro->update($request->only([
            'titulo',
            'titulo_en',
            'autor',
            'editorial',
            'anio',
            'estado',
            'categoria_id',
            'sinopsis',
            'sinopsis_en',
        ]));

        return redirect()->route('libros.index')->with('success', __('Libro actualizado correctamente.'));
    }

    /**
     * Eliminar un libro.
     */
    public function destroy(Libro $libro)
    {
        $libro->delete();
        return redirect()->route('libros.index')->with('success', __('Libro eliminado correctamente.'));
    }
}
