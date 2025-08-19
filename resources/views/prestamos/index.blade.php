<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Mis Préstamos') }} | Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#e6f0f4] text-gray-800 font-sans">

    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- Encabezado --}}
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-[#1e3a8a] mb-2">📚 {{ __('Mis Préstamos') }}</h1>
            <p class="text-gray-600">{{ __('Consulta el estado de tus préstamos.') }}</p>
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

        {{-- Tabla de préstamos activos --}}
        <h2 class="text-2xl font-bold text-blue-700 mb-4">📖 {{ __('Préstamos Activos') }}</h2>
        <div class="bg-white rounded-lg shadow-md overflow-x-auto mb-10">
            <table class="w-full table-auto">
                <thead class="bg-[#1e3a8a] text-white">
                    <tr>
                        <th class="py-3 px-4">{{ __('Título del libro') }}</th>
                        <th class="py-3 px-4">{{ __('Fecha de inicio') }}</th>
                        <th class="py-3 px-4">{{ __('Fecha de fin') }}</th>
                        <th class="py-3 px-4">{{ __('Estado') }}</th>
                        <th class="py-3 px-4 text-center">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamos->where('estado', 'activo') as $prestamo)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $prestamo->libro->titulo_localizado }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">
                                {{ $prestamo->fecha_fin ? \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') : '—' }}
                            </td>
                            <td class="py-3 px-4 text-blue-600 font-semibold">{{ __('Activo') }}</td>
                            <td class="py-3 px-4 text-center space-y-1">
                                {{-- Botón prorrogar (solo si no se ha prorrogado ya) --}}
                                @if(!$prestamo->ya_prorrogado)
                                    <form action="{{ route('prestamos.prorrogar', $prestamo->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm transition">
                                            {{ __('Prorrogar +25 días') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm">{{ __('No disponible') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">{{ __('No tienes préstamos activos.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tabla de préstamos devueltos --}}
        <h2 class="text-2xl font-bold text-gray-700 mb-4">📦 {{ __('Préstamos Devueltos') }}</h2>
        <div class="bg-white rounded-lg shadow-md overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-600 text-white">
                    <tr>
                        <th class="py-3 px-4">{{ __('Título del libro') }}</th>
                        <th class="py-3 px-4">{{ __('Fecha de inicio') }}</th>
                        <th class="py-3 px-4">{{ __('Fecha de fin') }}</th>
                        <th class="py-3 px-4">{{ __('Estado') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamos->where('estado', 'devuelto') as $prestamo)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $prestamo->libro->titulo_localizado }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">
                                {{ $prestamo->fecha_fin ? \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') : '—' }}
                            </td>
                            <td class="py-3 px-4 text-gray-600">{{ __('Devuelto') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">{{ __('No tienes préstamos devueltos.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Botón volver --}}
        <div class="mt-8 flex justify-center">
            <a href="{{ route('cuenta.index') }}"
                class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
                ← {{ __('Volver a Mi Cuenta') }}
            </a>
        </div>
    </div>

</body>
</html>
