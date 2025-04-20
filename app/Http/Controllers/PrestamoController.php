<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestamoController extends Controller
{
    /**
     * Mostrar los préstamos del usuario autenticado.
     */
    public function index()
    {
        $prestamos = Prestamo::with('libro')
            ->where('user_id', Auth::id())
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('prestamos.index', compact('prestamos'));
    }

    /**
     * Mostrar formulario para crear un préstamo (opcional).
     */
    public function create()
    {
        return redirect()->route('libros.index');
    }

    /**
     * Guardar un nuevo préstamo rápido (sin fechas).
     */
    public function store(Request $request)
    {
        $request->validate([
            'libro_id' => 'required|exists:libros,id',
        ]);

        $libro = Libro::findOrFail($request->libro_id);

        if ($libro->estado !== 'disponible') {
            return redirect()->back()->with('error', 'Este libro no está disponible.');
        }

        Prestamo::create([
            'user_id' => Auth::id(),
            'libro_id' => $libro->id,
            'fecha_inicio' => now(),
            'estado' => 'activo',
        ]);

        $libro->update(['estado' => 'prestado']);

        return redirect()->route('prestamos.index')->with('success', 'Préstamo registrado correctamente.');
    }

    /**
     * Mostrar detalles de un préstamo (opcional).
     */
    public function show(Prestamo $prestamo)
    {
        if ($prestamo->user_id !== Auth::id()) {
            abort(403);
        }

        return view('prestamos.show', compact('prestamo'));
    }

    /**
     * Mostrar formulario para editar (no necesario).
     */
    public function edit(Prestamo $prestamo)
    {
        return redirect()->route('prestamos.index');
    }

    /**
     * Actualizar préstamo (ej: marcar como devuelto).
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        if ($prestamo->user_id !== Auth::id()) {
            abort(403);
        }

        $prestamo->update([
            'fecha_fin' => now(),
            'estado' => 'devuelto',
        ]);

        $prestamo->libro->update(['estado' => 'disponible']);

        return redirect()->route('prestamos.index')->with('success', 'Libro devuelto correctamente.');
    }

    /**
     * Eliminar un préstamo (opcional, si se permite cancelar).
     */
    public function destroy(Prestamo $prestamo)
    {
        if ($prestamo->user_id !== Auth::id()) {
            abort(403);
        }

        if ($prestamo->estado !== 'devuelto') {
            $prestamo->libro->update(['estado' => 'disponible']);
        }

        $prestamo->delete();

        return redirect()->route('prestamos.index')->with('success', 'Préstamo cancelado correctamente.');
    }

    /**
     * Mostrar formulario para préstamo manual con fechas.
     */
    public function formulario(Libro $libro)
    {
        if ($libro->estado !== 'disponible') {
            return redirect()->route('libros.index')->with('error', 'Este libro no está disponible para préstamo.');
        }

        return view('prestamos.formulario', compact('libro'));
    }

    /**
     * Procesar formulario de préstamo con fechas.
     */
    public function realizar(Request $request, Libro $libro)
    {
        $request->validate([
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        if ($libro->estado !== 'disponible') {
            return redirect()->route('libros.index')->with('error', 'Este libro no está disponible.');
        }

        Prestamo::create([
            'user_id' => Auth::id(),
            'libro_id' => $libro->id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => 'activo',
        ]);

        $libro->update(['estado' => 'prestado']);

        return redirect()->route('libros.index')->with('success', 'El préstamo ha sido registrado correctamente.');
    }
}
