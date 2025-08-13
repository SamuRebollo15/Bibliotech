<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    public function index()
    {
        $prestamos = Prestamo::with('libro')
            ->where('user_id', Auth::id())
            ->orderBy('fecha_inicio', 'desc')
            ->get()
            ->map(function ($prestamo) {
                $inicio = Carbon::parse($prestamo->fecha_inicio);
                $fin = $prestamo->fecha_fin ? Carbon::parse($prestamo->fecha_fin) : null;
                $maximaFecha = $inicio->copy()->addDays(14); // 7 originales + 7 prórroga
                $prestamo->ya_prorrogado = $fin && $fin->greaterThanOrEqualTo($maximaFecha);
                return $prestamo;
            });

        return view('prestamos.index', compact('prestamos'));
    }

    public function create()
    {
        return redirect()->route('libros.index');
    }

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
            'fecha_fin' => now()->addDays(7),
            'estado' => 'activo',
        ]);

        $libro->update(['estado' => 'prestado']);

        return redirect()->route('prestamos.index')->with('success', 'Préstamo registrado correctamente.');
    }

    public function gestion(Request $request)
    {
        if (!Auth::user()->esAdmin()) {
            abort(403);
        }

        $usuarioId = $request->input('usuario_id');
        $query = Prestamo::with(['libro', 'usuario'])->orderByDesc('fecha_inicio');

        if ($usuarioId) {
            $query->where('user_id', $usuarioId);
        }

        $prestamosActivos = (clone $query)->where('estado', 'activo')->get()->map(function ($prestamo) {
            $inicio = Carbon::parse($prestamo->fecha_inicio);
            $fin = $prestamo->fecha_fin ? Carbon::parse($prestamo->fecha_fin) : null;
            $maximaFecha = $inicio->copy()->addDays(14);
            $prestamo->ya_prorrogado = $fin && $fin->greaterThanOrEqualTo($maximaFecha);
            return $prestamo;
        });

        $prestamosDevueltos = (clone $query)->where('estado', 'devuelto')->get();
        $usuarios = \App\Models\User::orderBy('name')->get();

        return view('prestamos.gestion', compact(
            'prestamosActivos',
            'prestamosDevueltos',
            'usuarios',
            'usuarioId'
        ));
    }

    public function actualizarEstado(Request $request, Prestamo $prestamo)
    {
        if (!Auth::user()->esAdmin()) {
            abort(403);
        }

        $request->validate([
            'estado' => 'required|in:activo,devuelto',
        ]);

        $prestamo->estado = $request->estado;

        if ($request->estado === 'devuelto') {
            $prestamo->fecha_fin = now();
            $prestamo->libro->update(['estado' => 'disponible']);
        }

        $prestamo->save();

        return redirect()->route('admin.prestamos.gestion')->with('success', 'Estado del préstamo actualizado.');
    }

    public function show(Prestamo $prestamo)
    {
        if ($prestamo->user_id !== Auth::id()) {
            abort(403);
        }

        return view('prestamos.show', compact('prestamo'));
    }

    public function edit(Prestamo $prestamo)
    {
        return redirect()->route('prestamos.index');
    }

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

    public function formulario(Libro $libro)
    {
        if (Auth::user()->bloqueado) {
            return redirect()->route('libros.index')->with('error', 'No puedes solicitar préstamos porque tu cuenta está bloqueada.');
        }

        if ($libro->estado !== 'disponible') {
            return redirect()->route('libros.index')->with('error', 'Este libro no está disponible para préstamo.');
        }

        $fechaRecogida = Carbon::today();
        $fechaDevolucion = $fechaRecogida->copy()->addDays(7);

        return view('prestamos.formulario', compact('libro', 'fechaRecogida', 'fechaDevolucion'));
    }

    public function realizar(Request $request, Libro $libro)
    {
        if (Auth::user()->bloqueado) {
            return redirect()->route('libros.index')->with('error', 'No puedes alquilar libros porque tu cuenta está bloqueada.');
        }

        $request->validate([
            'fecha_inicio' => 'required|date|after_or_equal:today',
        ]);

        if ($libro->estado !== 'disponible') {
            return redirect()->route('libros.index')->with('error', 'Este libro no está disponible.');
        }

        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = $fechaInicio->copy()->addDays(7);

        Prestamo::create([
            'user_id' => Auth::id(),
            'libro_id' => $libro->id,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'estado' => 'activo',
        ]);

        $libro->update(['estado' => 'prestado']);

        return redirect()->route('libros.index')->with('success', 'El préstamo ha sido registrado correctamente.');
    }

    public function prorrogar(Prestamo $prestamo)
    {
        if ($prestamo->user_id !== Auth::id()) {
            abort(403);
        }

        $inicio = Carbon::parse($prestamo->fecha_inicio);
        $fin = $prestamo->fecha_fin ? Carbon::parse($prestamo->fecha_fin) : null;
        $maximaFecha = $inicio->copy()->addDays(14);

        if ($fin && $fin->greaterThanOrEqualTo($maximaFecha)) {
            return back()->with('error', 'No puedes prorrogar este préstamo más de una vez.');
        }

        $prestamo->fecha_fin = $fin
            ? $fin->copy()->addDays(7)
            : $inicio->copy()->addDays(7);

        $prestamo->save();

        return back()->with('success', 'Préstamo prorrogado correctamente por 7 días.');
    }
}
