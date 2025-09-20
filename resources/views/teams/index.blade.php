<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Equipos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Header Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">⚽ Equipos del Sistema</h1>
                            <p class="text-gray-600">Administra todos los equipos registrados</p>
                        </div>
                        <a href="{{ route('teams.create') }}"
                           class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            + Nuevo Equipo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filter by League -->
            @if(isset($leagues) && $leagues->count() > 1)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-4">
                        <div class="flex items-center space-x-4">
                            <label class="text-sm font-medium text-gray-700">Filtrar por liga:</label>
                            <select onchange="window.location.href = this.value"
                                    class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="{{ route('teams.index') }}">Todas las ligas</option>
                                @foreach($leagues as $league)
                                    <option value="{{ route('teams.index', ['league' => $league->id]) }}"
                                            {{ request('league') == $league->id ? 'selected' : '' }}>
                                        {{ $league->name }} ({{ $league->teams_count }} equipos)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Teams Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($teams->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Equipo
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Liga
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ubicación
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Partidos
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($teams as $team)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                        <span class="text-blue-600 font-bold text-sm">
                                                            {{ strtoupper(substr($team->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $team->name }}
                                                        </div>
                                                        @if($team->founded_year)
                                                            <div class="text-sm text-gray-500">
                                                                Fundado en {{ $team->founded_year }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $team->league->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $team->city ?: 'No especificada' }}
                                                @if($team->league->country)
                                                    <div class="text-xs text-gray-500">{{ $team->league->country }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @php
                                                    $totalMatches = $team->homeMatches->count() + $team->awayMatches->count();
                                                @endphp
                                                <div class="flex items-center">
                                                    <span class="font-medium">{{ $totalMatches }}</span>
                                                    @if($totalMatches > 0)
                                                        <span class="ml-2 text-xs text-gray-500">
                                                            ({{ $team->homeMatches->count() }}L / {{ $team->awayMatches->count() }}V)
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('teams.show', $team) }}"
                                                   class="text-blue-600 hover:text-blue-900">
                                                    Ver
                                                </a>
                                                <a href="{{ route('teams.edit', $team) }}"
                                                   class="text-yellow-600 hover:text-yellow-900">
                                                    Editar
                                                </a>
                                                <form action="{{ route('teams.destroy', $team) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar este equipo?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">⚽</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay equipos registrados</h3>
                            <p class="text-gray-500 mb-6">
                                @if(request('league'))
                                    No hay equipos en la liga seleccionada.
                                @else
                                    Comienza creando equipos para organizar partidos y generar predicciones.
                                @endif
                            </p>
                            <a href="{{ route('teams.create', request('league') ? ['league' => request('league')] : []) }}"
                               class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg">
                                Crear Primer Equipo
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            @if($teams->count() > 0)
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">📊 Estadísticas Rápidas</h3>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $teams->count() }}</div>
                                <div class="text-sm text-gray-600">Total Equipos</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $teams->unique('league_id')->count() }}</div>
                                <div class="text-sm text-gray-600">Ligas Representadas</div>
                            </div>
                            <div class="text-center">
                                @php
                                    $totalMatches = 0;
                                    foreach($teams as $team) {
                                        $totalMatches += $team->homeMatches->count() + $team->awayMatches->count();
                                    }
                                    $totalMatches = $totalMatches / 2; // Avoid double counting
                                @endphp
                                <div class="text-2xl font-bold text-purple-600">{{ $totalMatches }}</div>
                                <div class="text-sm text-gray-600">Partidos Totales</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-yellow-600">{{ $teams->where('founded_year', '!=', null)->count() }}</div>
                                <div class="text-sm text-gray-600">Con Año Fundación</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-600">{{ $teams->where('city', '!=', null)->count() }}</div>
                                <div class="text-sm text-gray-600">Con Ciudad</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>