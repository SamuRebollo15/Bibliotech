<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('theme','light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Mis Préstamos') }} | Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script> tailwind.config = { darkMode: 'class' } </script>
</head>

<body class="font-sans bg-[#e6f0f4] text-gray-800 dark:bg-slate-900 dark:text-slate-100">

    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- Controles: idioma + tema --}}
        <div class="flex justify-end gap-2 mb-4">
            <form method="POST" action="{{ route('cambiar.idioma') }}">
                @csrf
                <button type="submit"
                        class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 text-gray-800
                               dark:bg-gray-700 dark:text-slate-100 dark:hover:bg-gray-600 transition">
                    🌐 {{ app()->getLocale() === 'es' ? 'English' : 'Español' }}
                </button>
            </form>

            <form method="POST" action="{{ route('tema.toggle') }}">
                @csrf
                <button type="submit"
                        class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 text-gray-800
                               dark:bg-gray-700 dark:text-slate-100 dark:hover:bg-gray-600 transition">
                    @if(session('theme','light') === 'dark')
                        ☀️ {{ __('Tema claro') }}
                    @else
                        🌙 {{ __('Tema oscuro') }}
                    @endif
                </button>
            </form>
        </div>

        {{-- Encabezado --}}
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-[#1e3a8a] dark:text-blue-300 mb-2">📚 {{ __('Mis Préstamos') }}</h1>
            <p class="text-gray-600 dark:text-slate-300">{{ __('Consulta el estado de tus préstamos.') }}</p>
        </div>

        {{-- Mensajes --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 p-4 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tabla de préstamos activos --}}
        <h2 class="text-2xl font-bold text-blue-700 dark:text-blue-300 mb-4">📖 {{ __('Préstamos Activos') }}</h2>
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-x-auto mb-10 border border-gray-200 dark:border-slate-700">
            <table class="w-full table-auto">
                <thead class="bg-[#1e3a8a] text-white dark:bg-blue-900">
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
                        <tr class="border-b border-gray-200 dark:border-slate-700">
                            <td class="py-3 px-4">{{ $prestamo->libro->titulo_localizado }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">
                                {{ $prestamo->fecha_fin ? \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') : '—' }}
                            </td>
                            <td class="py-3 px-4 text-blue-700 dark:text-blue-300 font-semibold">{{ __('Activo') }}</td>
                            <td class="py-3 px-4 text-center space-y-1">
                                {{-- Botón prorrogar (solo si no se ha prorrogado ya) --}}
                                @if(!$prestamo->ya_prorrogado)
                                    <form action="{{ route('prestamos.prorrogar', $prestamo->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm transition">
                                            {{ __('Prorrogar +7 días') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 dark:text-slate-400 text-sm">{{ __('No disponible') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500 dark:text-slate-400">{{ __('No tienes préstamos activos.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tabla de préstamos devueltos --}}
        <h2 class="text-2xl font-bold text-gray-700 dark:text-slate-200 mb-4">📦 {{ __('Préstamos Devueltos') }}</h2>
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-x-auto border border-gray-200 dark:border-slate-700">
            <table class="w-full table-auto">
                <thead class="bg-gray-600 text-white dark:bg-gray-700">
                    <tr>
                        <th class="py-3 px-4">{{ __('Título del libro') }}</th>
                        <th class="py-3 px-4">{{ __('Fecha de inicio') }}</th>
                        <th class="py-3 px-4">{{ __('Fecha de fin') }}</th>
                        <th class="py-3 px-4">{{ __('Estado') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamos->where('estado', 'devuelto') as $prestamo)
                        <tr class="border-b border-gray-200 dark:border-slate-700">
                            <td class="py-3 px-4">{{ $prestamo->libro->titulo_localizado }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">
                                {{ $prestamo->fecha_fin ? \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') : '—' }}
                            </td>
                            <td class="py-3 px-4 text-gray-700 dark:text-slate-300">{{ __('Devuelto') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500 dark:text-slate-400">{{ __('No tienes préstamos devueltos.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Botón volver --}}
        <div class="mt-8 flex justify-center">
            <a href="{{ route('cuenta.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded transition">
                ← {{ __('Volver a Mi Cuenta') }}
            </a>
        </div>
    </div>

</body>
</html>
