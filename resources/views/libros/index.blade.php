<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#e6f0f4] text-[#1a1a1a] font-sans">

    {{-- Toast de éxito --}}
    @if(session('success'))
    <div id="toast"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50 transition-opacity duration-300">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.opacity = '0';
            }
        }, 3000);
    </script>
    @endif

    <div class="max-w-6xl mx-auto py-8 px-4">

        {{-- Logo + Nombre + Autenticación --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/logo_bibliotech.png') }}" alt="Logo Bibliotech" class="h-16">
                <h1 class="text-4xl font-extrabold text-[#1e3a8a] tracking-wide">Bibliotech</h1>
            </div>

            <div class="flex items-center gap-4">
                @auth
                <a href="{{ route('cuenta.index') }}" class="text-[#1e3a8a] font-semibold hover:underline hover:text-[#3b82f6] transition">
                    {{ Auth::user()->name }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition shadow">
                        Cerrar sesión
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition shadow">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition shadow">
                    Registrarse
                </a>
                @endauth
            </div>
        </div>

        {{-- Botón para añadir nuevo libro (solo admin) --}}
        @auth
        @if(Auth::user()->esAdmin())
        <div class="flex justify-end mb-4">
            <a href="{{ route('libros.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                ➕ Añadir nuevo libro
            </a>
        </div>
        @endif
        @endauth
        {{-- Buscador unificado por título o autor --}}
<form method="GET" action="{{ route('libros.index') }}" class="mb-6 bg-white p-4 rounded shadow border border-gray-200">
    <div class="flex items-center gap-4">
        <input type="text" name="busqueda" placeholder="Buscar por título o autor" value="{{ request('busqueda') }}"
            class="flex-grow px-4 py-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">

        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Buscar
        </button>

        @if(request('busqueda'))
        <a href="{{ route('libros.index') }}" class="text-red-600 underline text-sm hover:text-red-800">
            Limpiar
        </a>
        @endif
    </div>
</form>

        {{-- Tabla de libros --}}
        <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
            <table class="w-full text-left table-auto">
                <thead class="bg-[#1e3a8a] text-white">
                    <tr>
                        <th class="py-3 px-4">Título</th>
                        <th class="py-3 px-4">Autor</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($libros as $libro)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="py-3 px-4 font-medium">{{ $libro->titulo }}</td>
                        <td class="py-3 px-4">{{ $libro->autor }}</td>
                        <td class="py-3 px-4">
                            @if($libro->estado === 'disponible')
                            <span class="text-green-600 font-semibold">Disponible</span>
                            @elseif($libro->estado === 'prestado')
                            <span class="text-red-600 font-semibold">Prestado</span>
                            @else
                            <span class="text-yellow-600 font-semibold">Reservado</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center space-x-2">
                            {{-- Ver --}}
                            <a href="{{ route('libros.show', $libro->id) }}"
                                class="bg-[#1e3a8a] text-white px-3 py-1 rounded text-sm hover:bg-[#3b82f6] transition">
                                Ver
                            </a>

                            @auth
                            @if(Auth::user()->esAdmin())
                            {{-- Editar --}}
                            <a href="{{ route('libros.edit', $libro->id) }}"
                                class="bg-yellow-500 text-white text-sm px-3 py-1 rounded hover:bg-yellow-600 transition">
                                Editar
                            </a>

                            {{-- Eliminar (abre modal) --}}
                            <button type="button"
                                onclick="openModal({{ $libro->id }})"
                                class="bg-red-600 text-white text-sm px-3 py-1 rounded hover:bg-red-700 transition">
                                Eliminar
                            </button>
                            @endif
                            @endauth
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal de confirmación --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md border shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-center">¿Estás seguro?</h2>
            <p class="mb-6 text-center">Esta acción eliminará el libro permanentemente.</p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-between">
                    <button type="button"
                        onclick="closeModal()"
                        class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script para el modal --}}
    <script>
        function openModal(libroId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/libros/${libroId}`;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }
    </script>

</body>

</html>