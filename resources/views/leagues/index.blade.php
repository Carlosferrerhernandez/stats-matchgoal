<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Ligas') }}
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
                            <h1 class="text-2xl font-bold text-gray-800">🏆 Ligas y Competiciones</h1>
                            <p class="text-gray-600">Administra las competiciones disponibles en el sistema</p>
                        </div>
                        <a href="{{ route('leagues.create') }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            + Nueva Liga
                        </a>
                    </div>
                </div>
            </div>

            <!-- Leagues Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($leagues as $league)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $league->name }}</h3>
                                <div class="flex space-x-2">
                                    <a href="{{ route('leagues.show', $league) }}"
                                       class="text-blue-600 hover:text-blue-800"
                                       title="Ver detalles">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('leagues.edit', $league) }}"
                                       class="text-yellow-600 hover:text-yellow-800"
                                       title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('leagues.destroy', $league) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta liga?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Eliminar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @if($league->country)
                                <div class="flex items-center text-gray-600 mb-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $league->country }}
                                </div>
                            @endif

                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    {{ $league->teams_count }} equipos
                                </div>
                                <a href="{{ route('teams.index', ['league' => $league->id]) }}"
                                   class="text-sm text-blue-600 hover:text-blue-800">
                                    Ver equipos →
                                </a>
                            </div>

                            @if($league->description)
                                <p class="text-gray-600 text-sm mt-3">{{ Str::limit($league->description, 100) }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-12 text-center">
                                <div class="text-6xl mb-4">🏆</div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay ligas registradas</h3>
                                <p class="text-gray-500 mb-6">Comienza creando tu primera liga para organizar equipos y partidos</p>
                                <a href="{{ route('leagues.create') }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg">
                                    Crear Primera Liga
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Quick Stats -->
            @if($leagues->count() > 0)
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">📊 Estadísticas Rápidas</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $leagues->count() }}</div>
                                <div class="text-sm text-gray-600">Total Ligas</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $leagues->sum('teams_count') }}</div>
                                <div class="text-sm text-gray-600">Total Equipos</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-purple-600">{{ $leagues->where('teams_count', '>', 0)->count() }}</div>
                                <div class="text-sm text-gray-600">Ligas Activas</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-yellow-600">{{ $leagues->avg('teams_count') ? round($leagues->avg('teams_count'), 1) : 0 }}</div>
                                <div class="text-sm text-gray-600">Promedio Equipos</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>