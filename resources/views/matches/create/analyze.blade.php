<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Análisis y Predicción del Partido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200">
                                Paso 6 de 6 - Análisis Completo
                            </span>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-green-200">
                            <div style="width:100%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
                        </div>
                    </div>

                    <!-- Match Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6 rounded-lg mb-8">
                        <div class="text-center">
                            <h1 class="text-2xl font-bold mb-2">{{ $homeTeam->name }} vs {{ $awayTeam->name }}</h1>
                            <div class="flex justify-center items-center space-x-8 text-lg">
                                <div class="text-center">
                                    <div class="font-bold">{{ $matchData['home_win_percent'] }}%</div>
                                    <div class="text-sm opacity-90">Local</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold">{{ $matchData['draw_percent'] }}%</div>
                                    <div class="text-sm opacity-90">Empate</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold">{{ $matchData['away_win_percent'] }}%</div>
                                    <div class="text-sm opacity-90">Visitante</div>
                                </div>
                            </div>
                            <div class="mt-2 text-sm opacity-90">
                                📅 {{ date('d/m/Y H:i', strtotime($matchData['match_date'])) }}
                            </div>
                        </div>
                    </div>

                    @if($prediction)
                        <!-- Prediction Result -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-bold text-green-800 flex items-center">
                                    ✅ Predicción Generada
                                </h2>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Confianza: {{ $prediction->confidence_score }}%
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Market -->
                                <div class="bg-white p-4 rounded-lg border border-green-200">
                                    <div class="text-sm text-gray-600 mb-1">Mercado Recomendado</div>
                                    <div class="font-bold text-lg text-green-800">
                                        {{ $prediction->market->icon }} {{ $prediction->market->name }}
                                    </div>
                                </div>

                                <!-- Prediction -->
                                <div class="bg-white p-4 rounded-lg border border-green-200">
                                    <div class="text-sm text-gray-600 mb-1">Pronóstico</div>
                                    <div class="font-bold text-lg text-green-800">
                                        {{ $prediction->prediction }}
                                    </div>
                                </div>

                                <!-- Stake -->
                                <div class="bg-white p-4 rounded-lg border border-green-200">
                                    <div class="text-sm text-gray-600 mb-1">Stake Sugerido</div>
                                    <div class="font-bold text-lg text-green-800">
                                        {{ $prediction->suggested_stake }}/{{ $prediction->user->settings->max_stake_level ?? 4 }}
                                    </div>
                                </div>

                                <!-- Amount -->
                                <div class="bg-white p-4 rounded-lg border border-green-200">
                                    <div class="text-sm text-gray-600 mb-1">Monto Sugerido</div>
                                    <div class="font-bold text-lg text-green-800">
                                        ${{ number_format($prediction->calculateBetAmountCOP(), 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-gray-500">COP</div>
                                </div>
                            </div>

                            <!-- Reasoning -->
                            <div class="mt-6 bg-white p-4 rounded-lg border border-green-200">
                                <h3 class="font-semibold text-green-800 mb-2">📋 Razonamiento del Algoritmo</h3>
                                <p class="text-gray-700">{{ $prediction->reasoning }}</p>
                            </div>

                            @if($prediction->expected_odds)
                                <div class="mt-4 bg-blue-50 p-4 rounded-lg border border-blue-200">
                                    <h3 class="font-semibold text-blue-800 mb-2">💰 Análisis de Cuotas</h3>
                                    <p class="text-blue-700">
                                        Cuota esperada: <strong>{{ $prediction->expected_odds }}</strong>
                                        @if(isset($matchData['market_odds'][$prediction->market->key . '_odds']) && $matchData['market_odds'][$prediction->market->key . '_odds'])
                                            | Cuota disponible: <strong>{{ $matchData['market_odds'][$prediction->market->key . '_odds'] }}</strong>
                                            @php
                                                $availableOdds = $matchData['market_odds'][$prediction->market->key . '_odds'];
                                                $valuePercentage = (($availableOdds - $prediction->expected_odds) / $prediction->expected_odds) * 100;
                                            @endphp
                                            | Valor:
                                            <span class="{{ $valuePercentage > 0 ? 'text-green-600 font-bold' : 'text-red-600' }}">
                                                {{ $valuePercentage > 0 ? '+' : '' }}{{ number_format($valuePercentage, 1) }}%
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center space-x-4 mb-8">
                            <form method="POST" action="{{ route('matches.create.confirm') }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg text-lg">
                                    ✅ Confirmar y Guardar Predicción
                                </button>
                            </form>

                            <a href="{{ route('matches.create.step5') }}"
                               class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-3 px-6 rounded-lg text-lg">
                                🔄 Ajustar Cuotas
                            </a>
                        </div>

                    @else
                        <!-- No Prediction -->
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h2 class="text-xl font-bold text-red-800">❌ No se pudo generar una predicción</h2>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-lg border border-red-200">
                                <h3 class="font-semibold text-red-800 mb-3">Posibles razones:</h3>
                                <ul class="space-y-2 text-red-700">
                                    <li class="flex items-center">
                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                                        No hay suficientes datos estadísticos para los equipos
                                    </li>
                                    <li class="flex items-center">
                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                                        Ningún mercado cumple los criterios mínimos de confianza
                                    </li>
                                    <li class="flex items-center">
                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                                        La confianza del algoritmo está por debajo del umbral configurado
                                    </li>
                                    <li class="flex items-center">
                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                                        Las rachas de los equipos no son suficientemente sólidas
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-6 flex justify-center space-x-4">
                                <a href="{{ route('matches.create.step3') }}"
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    📊 Revisar Rachas del Local
                                </a>
                                <a href="{{ route('matches.create.step4') }}"
                                   class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                    📊 Revisar Rachas del Visitante
                                </a>
                                <a href="{{ route('matches.create.step5') }}"
                                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    💰 Revisar Cuotas
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Match Data Summary -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Home Team Stats -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-blue-800 mb-4 flex items-center">
                                🏠 {{ $homeTeam->name }} - Estadísticas
                            </h3>

                            @if(isset($matchData['home_stats']))
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Primer Gol:</span>
                                        <span class="font-medium">{{ $matchData['home_stats']['home_first_to_score_success'] }}/{{ $matchData['home_stats']['home_first_to_score_total'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">1T Ganador:</span>
                                        <span class="font-medium">{{ $matchData['home_stats']['home_first_half_winner_success'] }}/{{ $matchData['home_stats']['home_first_half_winner_total'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Ambos Anotan:</span>
                                        <span class="font-medium">{{ $matchData['home_stats']['home_both_teams_score_success'] }}/{{ $matchData['home_stats']['home_both_teams_score_total'] }}</span>
                                    </div>
                                    @if($matchData['home_stats']['home_no_defeats_total'])
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">Sin Derrotas:</span>
                                            <span class="font-medium">{{ $matchData['home_stats']['home_no_defeats_success'] }}/{{ $matchData['home_stats']['home_no_defeats_total'] }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Away Team Stats -->
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-purple-800 mb-4 flex items-center">
                                ✈️ {{ $awayTeam->name }} - Estadísticas
                            </h3>

                            @if(isset($matchData['away_stats']))
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-purple-700">Primer Gol:</span>
                                        <span class="font-medium">{{ $matchData['away_stats']['away_first_to_score_success'] }}/{{ $matchData['away_stats']['away_first_to_score_total'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-purple-700">1er Gol Contra:</span>
                                        <span class="font-medium">{{ $matchData['away_stats']['away_first_to_concede_success'] }}/{{ $matchData['away_stats']['away_first_to_concede_total'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-purple-700">1T Ganador:</span>
                                        <span class="font-medium">{{ $matchData['away_stats']['away_first_half_winner_success'] }}/{{ $matchData['away_stats']['away_first_half_winner_total'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-purple-700">1T Perdedor:</span>
                                        <span class="font-medium">{{ $matchData['away_stats']['away_first_half_loser_success'] }}/{{ $matchData['away_stats']['away_first_half_loser_total'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-purple-700">Ambos Anotan:</span>
                                        <span class="font-medium">{{ $matchData['away_stats']['away_both_teams_score_success'] }}/{{ $matchData['away_stats']['away_both_teams_score_total'] }}</span>
                                    </div>
                                    @if($matchData['away_stats']['away_no_wins_total'])
                                        <div class="flex justify-between">
                                            <span class="text-purple-700">Sin Victorias:</span>
                                            <span class="font-medium">{{ $matchData['away_stats']['away_no_wins_success'] }}/{{ $matchData['away_stats']['away_no_wins_total'] }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Market Odds Summary -->
                    @if(isset($matchData['market_odds']) && !empty(array_filter($matchData['market_odds'])))
                        <div class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">💰 Cuotas Introducidas</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($matchData['market_odds'] as $marketKey => $odds)
                                    @if($odds)
                                        <div class="bg-white p-3 rounded border">
                                            <div class="text-sm text-gray-600">{{ str_replace('_odds', '', $marketKey) }}</div>
                                            <div class="font-bold text-lg">{{ $odds }}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Final Actions -->
                    <div class="mt-8 text-center">
                        <a href="{{ route('matches.create.index') }}"
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg mr-4">
                            🔄 Crear Nuevo Partido
                        </a>
                        <a href="{{ route('predictions') }}"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                            📊 Ver Todas las Predicciones
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>