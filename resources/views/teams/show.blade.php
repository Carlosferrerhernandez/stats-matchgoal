<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $team->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Team Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-blue-600 font-bold text-xl">
                                    {{ strtoupper(substr($team->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800">⚽ {{ $team->name }}</h1>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $team->league->name }}
                                    </span>
                                    @if($team->city)
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $team->city }}
                                        </div>
                                    @endif
                                    @if($team->founded_year)
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Fundado en {{ $team->founded_year }}
                                        </div>
                                    @endif
                                </div>
                                @if($team->description)
                                    <p class="text-gray-600 mt-3">{{ $team->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('teams.edit', $team) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                                Editar Equipo
                            </a>
                            <a href="{{ route('matches.create.index', ['team' => $team->id]) }}"
                               class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                + Crear Partido
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $team->homeMatches->count() }}</div>
                        <div class="text-sm text-gray-600">Partidos Local</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $team->awayMatches->count() }}</div>
                        <div class="text-sm text-gray-600">Partidos Visitante</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $team->homeMatches->count() + $team->awayMatches->count() }}</div>
                        <div class="text-sm text-gray-600">Total Partidos</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $team->stats->count() }}</div>
                        <div class="text-sm text-gray-600">Estadísticas</div>
                    </div>
                </div>
            </div>

            <!-- Recent Matches -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">🏟️ Partidos Recientes</h2>

                    @php
                        $recentMatches = collect($team->homeMatches)->merge($team->awayMatches)
                            ->sortByDesc('created_at')->take(5);
                    @endphp

                    @if($recentMatches->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentMatches as $match)
                                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-center">
                                            <div class="font-medium text-sm">
                                                {{ $match->homeTeam->name }}
                                            </div>
                                            <div class="text-xs text-gray-500">Local</div>
                                        </div>
                                        <div class="text-2xl text-gray-400">VS</div>
                                        <div class="text-center">
                                            <div class="font-medium text-sm">
                                                {{ $match->awayTeam->name }}
                                            </div>
                                            <div class="text-xs text-gray-500">Visitante</div>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <div class="text-sm font-medium">
                                            {{ $match->match_date ? $match->match_date->format('d/m/Y H:i') : 'Fecha pendiente' }}
                                        </div>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucfirst($match->status) }}
                                            </span>
                                            @if($match->predictions->count() > 0)
                                                <span class="text-xs text-green-600">
                                                    {{ $match->predictions->count() }} predicción(es)
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-4xl mb-4">📅</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay partidos registrados</h3>
                            <p class="text-gray-500 mb-6">Este equipo aún no tiene partidos programados</p>
                            <a href="{{ route('matches.create.index', ['team' => $team->id]) }}"
                               class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg">
                                Crear Primer Partido
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Team Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">📊 Estadísticas del Equipo</h2>

                    @if($team->stats->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($team->stats as $stat)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="font-semibold text-gray-800">{{ $stat->league->name }}</h3>
                                        <span class="text-sm text-gray-500">Temporada {{ $stat->season }}</span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Primer gol:</span>
                                            <span class="font-medium">
                                                {{ $stat->streak_first_to_score_success }}/{{ $stat->streak_first_to_score_total }}
                                                ({{ $stat->streak_first_to_score_total > 0 ? round(($stat->streak_first_to_score_success / $stat->streak_first_to_score_total) * 100, 1) : 0 }}%)
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">1T ganador:</span>
                                            <span class="font-medium">
                                                {{ $stat->streak_first_half_winner_success }}/{{ $stat->streak_first_half_winner_total }}
                                                ({{ $stat->streak_first_half_winner_total > 0 ? round(($stat->streak_first_half_winner_success / $stat->streak_first_half_winner_total) * 100, 1) : 0 }}%)
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Ambos anotan:</span>
                                            <span class="font-medium">
                                                {{ $stat->streak_both_teams_score_success }}/{{ $stat->streak_both_teams_score_total }}
                                                ({{ $stat->streak_both_teams_score_total > 0 ? round(($stat->streak_both_teams_score_success / $stat->streak_both_teams_score_total) * 100, 1) : 0 }}%)
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Sin derrotas:</span>
                                            <span class="font-medium">
                                                {{ $stat->streak_no_defeats_success }}/{{ $stat->streak_no_defeats_total }}
                                                ({{ $stat->streak_no_defeats_total > 0 ? round(($stat->streak_no_defeats_success / $stat->streak_no_defeats_total) * 100, 1) : 0 }}%)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-4xl mb-4">📈</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay estadísticas registradas</h3>
                            <p class="text-gray-500">Las estadísticas se generarán automáticamente al crear partidos y usar el sistema de predicciones</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- League Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">🏆 Información de la Liga</h2>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $team->league->name }}</h3>
                            @if($team->league->country)
                                <p class="text-gray-600">📍 {{ $team->league->country }}</p>
                            @endif
                            @if($team->league->description)
                                <p class="text-gray-600 mt-2">{{ $team->league->description }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-blue-600">{{ $team->league->teams->count() }}</div>
                            <div class="text-sm text-gray-600">Equipos en la liga</div>
                            <a href="{{ route('leagues.show', $team->league) }}"
                               class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                                Ver liga completa →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="text-center space-x-4">
                <a href="{{ route('teams.index') }}"
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Volver a Equipos
                </a>
                <a href="{{ route('leagues.show', $team->league) }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Ver Liga
                </a>
            </div>
        </div>
    </div>
</x-app-layout>