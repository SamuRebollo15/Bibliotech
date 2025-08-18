<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ $libro->titulo_localizado }} - {{ __('Detalles') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#e6f0f4] text-[#1a1a1a] font-sans">

    <div class="max-w-3xl mx-auto py-8 px-4">

        {{-- Logo --}}
        <div class="flex justify-center mb-8">
            <img src="{{ asset('storage/logo_bibliotech.png') }}" alt="Logo Bibliotech" class="h-20">
        </div>

        <h1 class="text-3xl font-bold text-center mb-6">📖 {{ __('Detalles del libro') }}</h1>

        <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
            <table class="w-full text-left table-auto">
                <tbody>
                    <tr class="border-b">
                        <th class="py-3 px-4 bg-gray-100 w-1/3">{{ __('Título') }}</th>
                        <td class="py-3 px-4">{{ $libro->titulo_localizado }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-3 px-4 bg-gray-100">{{ __('Autor') }}</th>
                        <td class="py-3 px-4">{{ $libro->autor }}</td>
                    </tr>
                    @if($libro->editorial)
                    <tr class="border-b">
                        <th class="py-3 px-4 bg-gray-100">{{ __('Editorial') }}</th>
                        <td class="py-3 px-4">{{ $libro->editorial }}</td>
                    </tr>
                    @endif
                    @if($libro->anio)
                    <tr class="border-b">
                        <th class="py-3 px-4 bg-gray-100">{{ __('Año') }}</th>
                        <td class="py-3 px-4">{{ $libro->anio }}</td>
                    </tr>
                    @endif
                    @if($libro->categoria)
                    <tr class="border-b">
                        <th class="py-3 px-4 bg-gray-100">{{ __('Categoría') }}</th>
                        <td class="py-3 px-4">{{ app()->getLocale() === 'en' && $libro->categoria->nombre_en ? $libro->categoria->nombre_en : $libro->categoria->nombre }}</td>
                    </tr>
                    @endif
                    @if($libro->sinopsis || $libro->sinopsis_en)
                    <tr class="border-b">
                        <th class="py-3 px-4 bg-gray-100">{{ __('Sinopsis') }}</th>
                        <td class="py-3 px-4 text-justify">{{ $libro->sinopsis_localizada }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th class="py-3 px-4 bg-gray-100">{{ __('Estado') }}</th>
                        <td class="py-3 px-4">
                            @if($libro->estado === 'disponible')
                            <span class="text-green-600 font-semibold">{{ __('Disponible') }}</span>
                            @elseif($libro->estado === 'prestado')
                            <span class="text-red-600 font-semibold">{{ __('Prestado') }}</span>
                            @else
                            <span class="text-yellow-600 font-semibold">{{ __('Reservado') }}</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Botones --}}
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('libros.index') }}" class="bg-[#1e3a8a] text-white px-4 py-2 rounded hover:bg-[#3b82f6] transition">
                ← {{ __('Volver al catálogo') }}
            </a>

            @auth
            @if(Auth::user()->bloqueado)
            <button class="bg-red-500 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                {{ __('Cuenta bloqueada') }}
            </button>
            @elseif($libro->estado === 'disponible' && !Auth::user()->esAdmin())
            <a href="{{ route('prestamos.formulario', $libro) }}"
                class="bg-[#1e3a8a] text-white px-4 py-2 rounded hover:bg-[#3b82f6] transition">
                {{ __('Alquilar') }}
            </a>
            @elseif($libro->estado !== 'disponible')
            <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                {{ __('No disponible') }}
            </button>
            @endif
            @else
            <a href="{{ route('login') }}" class="bg-[#1e3a8a] text-white px-4 py-2 rounded hover:bg-[#3b82f6] transition">
                {{ __('Inicia sesión para alquilar') }}
            </a>
            @endauth
        </div>

    </div>

</body>

</html>
