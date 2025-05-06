<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Préstamos | Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#e6f0f4] text-gray-800 font-sans">

    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- Encabezado --}}
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-[#1e3a8a] mb-2">📚 Mis Préstamos</h1>
            <p class="text-gray-600">Consulta el estado de tus préstamos actuales.</p>
        </div>

        {{-- Mensajes --}}
        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
        @elseif(session('error'))
        <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
            {{ session('error') }}
        </div>
        @endif

        {{-- Tabla de préstamos --}}
        <div class="bg-white rounded-lg shadow-md overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-[#1e3a8a] text-white">
                    <tr>
                        <th class="py-3 px-4">Título del libro</th>
                        <th class="py-3 px-4">Fecha de inicio</th>
                        <th class="py-3 px-4">Fecha de fin</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamos as $prestamo)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $prestamo->libro->titulo }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">
                            {{ $prestamo->fecha_fin ? \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') : '—' }}
                        </td>
                        <td class="py-3 px-4 capitalize">
                            @if($prestamo->estado === 'activo')
                            <span class="text-blue-600 font-semibold">Activo</span>
                            @else
                            <span class="text-gray-600">{{ $prestamo->estado }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if($prestamo->estado === 'activo')
                            <button onclick="abrirModal({{ $prestamo->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition text-sm">
                                Cancelar
                            </button>
                            @else
                            <span class="text-gray-400 text-sm">No disponible</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">No tienes préstamos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Botón volver --}}
        <div class="mt-8 flex justify-center">
            <a href="{{ route('cuenta.index') }}"
                class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
                ← Volver a Mi Cuenta
            </a>
        </div>
    </div>

    {{-- Modal personalizado --}}
    <div id="modalCancelar" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg border">
            <h2 class="text-xl font-bold text-center text-[#1e3a8a] mb-4">¿Cancelar préstamo?</h2>
            <p class="text-center text-gray-600 mb-6">Esta acción eliminará el préstamo y el libro volverá a estar disponible.</p>
            <form id="formCancelar" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-between">
                    <button type="button" onclick="cerrarModal()"
                        class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script modal --}}
    <script>
        function abrirModal(idPrestamo) {
            const modal = document.getElementById('modalCancelar');
            const form = document.getElementById('formCancelar');
            form.action = `/prestamos/${idPrestamo}`;
            modal.classList.remove('hidden');
        }

        function cerrarModal() {
            const modal = document.getElementById('modalCancelar');
            modal.classList.add('hidden');
        }
    </script>

</body>
</html>
