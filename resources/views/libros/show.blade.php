<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $libro->titulo }} - Detalles</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e6f0f4] text-[#1a1a1a] font-sans">

    <div class="max-w-3xl mx-auto py-8 px-4">

        {{-- Logo --}}
        <div class="flex justify-center mb-8">
            <img src="{{ asset('storage/logo_bibliotech.png') }}" alt="Logo Bibliotech" class="h-20">
        </div>

        <h1 class="text-3xl font-bold text-center mb-6">📖 Detalles del libro</h1>

        <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
            <table class="w-full text-left table-auto">
                <tbody>
                    <tr class="border-b">
                        <th class="py-3 px-4 bg-gray-100 w-1/3">Título</th>
                        <td class="py-3 px-4">{{ $libro->titulo }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-3 px-4 bg-gray-100">Autor</th>
                        <td class="py-3 px-4">{{ $libro->autor }}</td>
                    </tr>
                    @if($libro->editorial)
                        <tr class="border-b">
                            <th class="py-3 px-4 bg-gray-100">Editorial</th>
                            <td class="py-3 px-4">{{ $libro->editorial }}</td>
                        </tr>
                    @endif
                    @if($libro->anio)
                        <tr class="border-b">
                            <th class="py-3 px-4 bg-gray-100">Año</th>
                            <td class="py-3 px-4">{{ $libro->anio }}</td>
                        </tr>
                    @endif
                    @if($libro->categoria)
                        <tr class="border-b">
                            <th class="py-3 px-4 bg-gray-100">Categoría</th>
                            <td class="py-3 px-4">{{ $libro->categoria->nombre }}</td>
                        </tr>
                    @endif
                    @if($libro->sinopsis)
                        <tr class="border-b">
                            <th class="py-3 px-4 bg-gray-100">Sinopsis</th>
                            <td class="py-3 px-4 text-justify">{{ $libro->sinopsis }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th class="py-3 px-4 bg-gray-100">Estado</th>
                        <td class="py-3 px-4">
                            @if($libro->estado === 'disponible')
                                <span class="text-green-600 font-semibold">Disponible</span>
                            @elseif($libro->estado === 'prestado')
                                <span class="text-red-600 font-semibold">Prestado</span>
                            @else
                                <span class="text-yellow-600 font-semibold">Reservado</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Botones --}}
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('libros.index') }}" class="bg-[#1e3a8a] text-white px-4 py-2 rounded hover:bg-[#3b82f6] transition">
                ← Volver al catálogo
            </a>

            @auth
                @if($libro->estado === 'disponible' && !Auth::user()->esAdmin())
                    <a href="{{ route('prestamos.formulario', $libro) }}"
                        class="bg-[#1e3a8a] text-white px-4 py-2 rounded hover:bg-[#3b82f6] transition">
                        Alquilar
                    </a>
                @elseif($libro->estado !== 'disponible')
                    <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                        No disponible
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}" class="bg-[#1e3a8a] text-white px-4 py-2 rounded hover:bg-[#3b82f6] transition">
                    Inicia sesión para alquilar
                </a>
            @endauth
        </div>

    </div>

</body>
</html>
