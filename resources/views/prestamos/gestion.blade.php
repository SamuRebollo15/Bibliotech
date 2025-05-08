<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Préstamos | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 font-sans">

    <div class="max-w-6xl mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-800 mb-6 text-center">📚 Gestión de Préstamos</h1>

        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-blue-800 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Usuario</th>
                        <th class="py-3 px-4 text-left">Libro</th>
                        <th class="py-3 px-4 text-left">Fecha de inicio</th>
                        <th class="py-3 px-4 text-left">Fecha de fin</th>
                        <th class="py-3 px-4 text-left">Estado</th>
                        <th class="py-3 px-4 text-center">Actualizar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestamos as $prestamo)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $prestamo->usuario->name }}</td>
                        <td class="py-3 px-4">{{ $prestamo->libro->titulo }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ $prestamo->fecha_fin ? \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') : '—' }}</td>
                        <td class="py-3 px-4 capitalize">{{ $prestamo->estado }}</td>
                        <td class="py-3 px-4 text-center">
                            @if($prestamo->estado !== 'devuelto')
                            <form action="{{ route('admin.prestamos.actualizar', $prestamo->id) }}" method="POST">

                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="estado" value="devuelto">
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm transition">Marcar como devuelto</button>
                            </form>
                            @else
                            <span class="text-gray-500 text-sm">Devuelto</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-10 flex justify-center">
            <a href="{{ route('cuenta.index') }}"
                class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
                ← Volver a Mi Cuenta
            </a>
        </div>

    </div>

</body>

</html>