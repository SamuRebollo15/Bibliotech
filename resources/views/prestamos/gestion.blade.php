<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

<div class="max-w-7xl mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-blue-800 mb-6 text-center">📚 Gestión de Préstamos</h1>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-800 p-4 rounded mb-6">{{ session('error') }}</div>
    @endif

    {{-- Filtro por usuario --}}
    <div class="mb-6 max-w-2xl mx-auto">
        <label class="block mb-2 font-semibold">Filtrar por usuario:</label>
        <div class="flex gap-4 items-center">
            <form method="GET" action="{{ route('admin.prestamos.gestion') }}" class="flex-grow">
                <select name="usuario_id" onchange="this.form.submit()" class="w-full p-2 rounded border border-gray-300">
                    <option value="">Todos los usuarios</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ $usuarioId == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            {{-- Botón bloquear/desbloquear solo si hay usuario seleccionado --}}
            @if($usuarioId)
                @php
                    $usuarioSeleccionado = $usuarios->firstWhere('id', $usuarioId);
                @endphp
                @if(!$usuarioSeleccionado->esAdmin())
                    @if($usuarioSeleccionado->bloqueado)
                        <form method="POST" action="{{ route('admin.usuarios.desbloquear', $usuarioSeleccionado->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                Desbloquear
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.usuarios.bloquear', $usuarioSeleccionado->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                Bloquear
                            </button>
                        </form>
                    @endif
                @endif
            @endif
        </div>
    </div>

    {{-- Préstamos activos --}}
    <h2 class="text-xl font-bold text-blue-700 mb-3">📘 Préstamos Activos</h2>
    <div class="bg-white rounded shadow overflow-x-auto mb-8">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-blue-800 text-white">
            <tr>
                <th class="py-3 px-4">Usuario</th>
                <th class="py-3 px-4">Libro</th>
                <th class="py-3 px-4">Inicio</th>
                <th class="py-3 px-4">Fin</th>
                <th class="py-3 px-4">Estado</th>
                <th class="py-3 px-4 text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($prestamosActivos as $prestamo)
                <tr class="border-b">
                    <td class="py-3 px-4">{{ $prestamo->usuario->name }}</td>
                    <td class="py-3 px-4">{{ $prestamo->libro->titulo }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4 text-blue-600 font-semibold capitalize">{{ $prestamo->estado }}</td>
                    <td class="py-3 px-4 text-center">
                        <form action="{{ route('admin.prestamos.actualizar', $prestamo->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="estado" value="devuelto">
                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm transition">
                                Marcar como devuelto
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">No hay préstamos activos.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Préstamos devueltos --}}
    <h2 class="text-xl font-bold text-gray-700 mb-3">📗 Préstamos Devueltos</h2>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-gray-700 text-white">
            <tr>
                <th class="py-3 px-4">Usuario</th>
                <th class="py-3 px-4">Libro</th>
                <th class="py-3 px-4">Inicio</th>
                <th class="py-3 px-4">Fin</th>
                <th class="py-3 px-4">Estado</th>
            </tr>
            </thead>
            <tbody>
            @forelse($prestamosDevueltos as $prestamo)
                <tr class="border-b">
                    <td class="py-3 px-4">{{ $prestamo->usuario->name }}</td>
                    <td class="py-3 px-4">{{ $prestamo->libro->titulo }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4 text-gray-600 capitalize">{{ $prestamo->estado }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">No hay préstamos devueltos.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Botón volver --}}
    <div class="mt-8 flex justify-center">
        <a href="{{ route('cuenta.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
            ← Volver a Mi Cuenta
        </a>
    </div>
</div>

</body>
</html>
