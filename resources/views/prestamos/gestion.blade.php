<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('theme','light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Gestión de Préstamos') }} | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script> tailwind.config = { darkMode: 'class' } </script>
</head>
<body class="bg-gray-100 dark:bg-slate-900 text-gray-800 dark:text-slate-100 font-sans">

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- Controles (idioma/tema) --}}
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

    {{-- Título --}}
    <h1 class="text-3xl font-bold text-blue-800 dark:text-blue-300 mb-6 text-center">
        📚 {{ __('Gestión de Préstamos') }}
    </h1>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200 p-4 rounded mb-6">
            {{ __(session('success')) }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-200 p-4 rounded mb-6">
            {{ __(session('error')) }}
        </div>
    @endif

    {{-- Filtro por usuario --}}
    <div class="mb-6 max-w-2xl mx-auto">
        <label class="block mb-2 font-semibold">{{ __('Filtrar por usuario') }}:</label>
        <div class="flex gap-4 items-center">
            <form method="GET" action="{{ route('admin.prestamos.gestion') }}" class="flex-grow">
                <select name="usuario_id" onchange="this.form.submit()"
                        class="w-full p-2 rounded border border-gray-300 bg-white text-gray-900
                               dark:bg-slate-800 dark:text-slate-100 dark:border-slate-700">
                    <option value="">{{ __('Todos los usuarios') }}</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ $usuarioId == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            {{-- Botón bloquear/desbloquear --}}
            @if($usuarioId)
                @php
                    $usuarioSeleccionado = $usuarios->firstWhere('id', $usuarioId);
                @endphp
                @if(!$usuarioSeleccionado->esAdmin())
                    @if($usuarioSeleccionado->bloqueado)
                        <form method="POST" action="{{ route('admin.usuarios.desbloquear', $usuarioSeleccionado->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                {{ __('Desbloquear') }}
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.usuarios.bloquear', $usuarioSeleccionado->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                {{ __('Bloquear') }}
                            </button>
                        </form>
                    @endif
                @endif
            @endif
        </div>
    </div>

    {{-- Préstamos activos --}}
    <h2 class="text-xl font-bold text-blue-700 dark:text-blue-300 mb-3">📘 {{ __('Préstamos Activos') }}</h2>
    <div class="bg-white dark:bg-slate-800 rounded shadow overflow-x-auto mb-8 border border-gray-200 dark:border-slate-700">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-blue-800 text-white dark:bg-blue-900">
                <tr>
                    <th class="py-3 px-4 text-left">{{ __('Usuario') }}</th>
                    <th class="py-3 px-4 text-left">{{ __('Libro') }}</th>
                    <th class="py-3 px-4 text-left">{{ __('Inicio') }}</th>
                    <th class="py-3 px-4 text-left">{{ __('Fin') }}</th>
                    <th class="py-3 px-4 text-left">{{ __('Estado') }}</th>
                    <th class="py-3 px-4 text-center">{{ __('Acciones') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamosActivos as $prestamo)
                    <tr class="border-b border-gray-200 dark:border-slate-700">
                        <td class="py-3 px-4">{{ $prestamo->usuario->name }}</td>
                        <td class="py-3 px-4">{{ $prestamo->libro->titulo_localizado }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4 text-blue-700 dark:text-blue-300 font-semibold capitalize">
                            {{ __($prestamo->estado) }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('admin.prestamos.actualizar', $prestamo->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="estado" value="devuelto">
                                <button type="submit"
                                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm transition">
                                    {{ __('Marcar como devuelto') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500 dark:text-slate-400">
                            {{ __('No hay préstamos activos.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Préstamos devueltos --}}
    <h2 class="text-xl font-bold text-gray-700 dark:text-slate-200 mb-3">📗 {{ __('Préstamos Devueltos') }}</h2>
    <div class="bg-white dark:bg-slate-800 rounded shadow overflow-x-auto border border-gray-200 dark:border-slate-700">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-gray-700 text-white dark:bg-gray-800">
                <tr>
                    <th class="py-3 px-4 text-left">{{ __('Usuario') }}</th>
                    <th class="py-3 px-4 text-left">{{ __('Libro') }}</th>
                    <th class="py-3 px-4 text-left">{{ __('Inicio') }}</th>
                    <th class="py-3 px-4 text-left">{{ __('Fin') }}</th>
                    <th class="py-3 px-4 text-left">{{ __('Estado') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamosDevueltos as $prestamo)
                    <tr class="border-b border-gray-200 dark:border-slate-700">
                        <td class="py-3 px-4">{{ $prestamo->usuario->name }}</td>
                        <td class="py-3 px-4">{{ $prestamo->libro->titulo_localizado }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4 text-gray-700 dark:text-slate-300 capitalize">{{ __($prestamo->estado) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500 dark:text-slate-400">
                            {{ __('No hay préstamos devueltos.') }}
                        </td>
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
