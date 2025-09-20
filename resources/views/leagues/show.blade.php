<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $league->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- League Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 flex items-center mb-2">
                                🏆 {{ $league->name }}
                            </h1>
                            @if($league->country)
                                <div class="flex items-center text-gray-600 mb-2">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $league->country }}
                                </div>
                            @endif
                            @if($league->description)
                                <p class="text-gray-600">{{ $league->description }}</p>
                            @endif
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('leagues.edit', $league) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                                Editar Liga
                            </a>
                            <a href="{{ route('teams.create', ['league' => $league->id]) }}"
                               class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                + Agregar Equipo
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $league->teams->count() }}</div>
                        <div class="text-sm text-gray-600">Equipos</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        @php
                            $totalMatches = 0;
                            foreach($league->teams as $team) {
                                $totalMatches += $team->homeMatches()->count() + $team->awayMatches()->count();
                            }
                            $totalMatches = $totalMatches / 2; // Avoid double counting
                        @endphp
                        <div class="text-3xl font-bold text-green-600">{{ $totalMatches }}</div>
                        <div class="text-sm text-gray-600">Partidos</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $league->created_at->diffForHumans() }}</div>
                        <div class="text-sm text-gray-600">Creada</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        @php
                            $activePredictions = 0;
                            foreach($league->teams as $team) {
                                $homeMatches = $team->homeMatches()->has('predictions')->count();
                                $awayMatches = $team->awayMatches()->has('predictions')->count();
                                $activePredictions += $homeMatches + $awayMatches;
                            }
                        @endphp
                        <div class="text-3xl font-bold text-yellow-600">{{ $activePredictions }}</div>
                        <div class="text-sm text-gray-600">Predicciones</div>
                    </div>
                </div>
            </div>

            <!-- Teams Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">⚽ Equipos de la Liga</h2>
                        @if($league->teams->count() >= 2)
                            <a href="{{ route('matches.create.index', ['league' => $league->id]) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Crear Partido
                            </a>
                        @endif
                    </div>

                    @if($league->teams->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($league->teams as $team)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold text-gray-800">{{ $team->name }}</h3>
                                        <div class="flex space-x-1">
                                            <a href="{{ route('teams.show', $team) }}"
                                               class="text-blue-600 hover:text-blue-800 text-sm">
                                                Ver
                                            </a>
                                            <span class="text-gray-300">|</span>
                                            <a href="{{ route('teams.edit', $team) }}"
                                               class="text-yellow-600 hover:text-yellow-800 text-sm">
                                                Editar
                                            </a>
                                        </div>
                                    </div>

                                    @if($team->city)
                                        <div class="text-sm text-gray-600 mb-2">
                                            📍 {{ $team->city }}
                                        </div>
                                    @endif

                                    @if($team->founded_year)
                                        <div class="text-sm text-gray-600 mb-2">
                                            📅 Fundado en {{ $team->founded_year }}
                                        </div>
                                    @endif

                                    <div class="flex justify-between text-xs text-gray-500 mt-3">
                                        <span>Partidos: {{ $team->homeMatches->count() + $team->awayMatches->count() }}</span>
                                        <span>Estadísticas: {{ $team->stats->count() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">⚽</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay equipos en esta liga</h3>
                            <p class="text-gray-500 mb-6">Comienza agregando equipos para poder crear partidos y generar predicciones</p>
                            <a href="{{ route('teams.create', ['league' => $league->id]) }}"
                               class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg">
                                Agregar Primer Equipo
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity -->
            @if($league->teams->count() > 0)
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">📈 Actividad Reciente</h3>

                        @php
                            $recentMatches = collect();
                            foreach($league->teams as $team) {
                                $homeMatches = $team->homeMatches()->latest()->limit(3)->get();
                                $awayMatches = $team->awayMatches()->latest()->limit(3)->get();
                                $recentMatches = $recentMatches->merge($homeMatches)->merge($awayMatches);
                            }
                            $recentMatches = $recentMatches->sortByDesc('created_at')->take(5);
                        @endphp

                        @if($recentMatches->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentMatches as $match)
                                    <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                                        <div>
                                            <div class="font-medium">
                                                {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                {{ $match->match_date ? $match->match_date->format('d/m/Y H:i') : 'Fecha pendiente' }}
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucfirst($match->status) }}
                                            </span>
                                            @if($match->predictions->count() > 0)
                                                <span class="text-sm text-green-600">
                                                    {{ $match->predictions->count() }} predicción(es)
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No hay actividad reciente</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Back to Leagues -->
            <div class="mt-6 text-center">
                <a href="{{ route('leagues.index') }}"
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Volver a Ligas
                </a>
            </div>
        </div>
    </div>
</x-app-layout>