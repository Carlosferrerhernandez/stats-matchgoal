<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Partido - Paso 4: Estadísticas Equipo Visitante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">
                                Paso 4 de 6
                            </span>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                            <div style="width:66.66%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                        </div>
                    </div>

                    <!-- Team Info -->
                    <div class="bg-purple-50 p-4 rounded-lg mb-6">
                        <div class="flex justify-center items-center">
                            <div class="text-center">
                                <div class="font-bold text-xl text-purple-800">✈️ {{ $awayTeam->name }}</div>
                                <div class="text-sm text-purple-600">Estadísticas Generales del Equipo</div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Form Section -->
                        <div>
                            <form method="POST" action="{{ route('matches.create.step4.store') }}" id="step4Form">
                                @csrf

                                <div class="space-y-6">
                                    <!-- Simple Streaks Section -->
                                    <div class="bg-gradient-to-r from-green-50 to-purple-50 p-4 rounded-lg border">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            📊 Rachas Simples (Número de partidos consecutivos)
                                        </h3>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="away_wins_streak" class="block text-sm font-medium text-gray-700 mb-1">
                                                    🏆 Racha de Victorias
                                                </label>
                                                <input type="number" name="away_wins_streak" id="away_wins_streak"
                                                       min="0" value="{{ old('away_wins_streak') }}"
                                                       placeholder="ej: 2 (2 victorias seguidas)"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                @error('away_wins_streak')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="away_defeats_streak" class="block text-sm font-medium text-gray-700 mb-1">
                                                    ❌ Racha de Derrotas
                                                </label>
                                                <input type="number" name="away_defeats_streak" id="away_defeats_streak"
                                                       min="0" value="{{ old('away_defeats_streak') }}"
                                                       placeholder="ej: 1 (1 derrota reciente)"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                @error('away_defeats_streak')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label for="away_no_defeats_streak" class="block text-sm font-medium text-gray-700 mb-1">
                                                🛡️ Racha Sin Derrotas
                                            </label>
                                            <input type="number" name="away_no_defeats_streak" id="away_no_defeats_streak"
                                                   min="0" value="{{ old('away_no_defeats_streak') }}"
                                                   placeholder="ej: 4 (4 partidos sin perder)"
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                            @error('away_no_defeats_streak')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mt-4">
                                            <label for="away_no_clean_sheet_streak" class="block text-sm font-medium text-gray-700 mb-1">
                                                🥅 Ninguna Portería a Cero
                                            </label>
                                            <input type="number" name="away_no_clean_sheet_streak" id="away_no_clean_sheet_streak"
                                                   min="0" value="{{ old('away_no_clean_sheet_streak') }}"
                                                   placeholder="ej: 3 (3 partidos sin portería imbatida)"
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                            @error('away_no_clean_sheet_streak')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Ratio Streaks Section -->
                                    <div class="bg-gradient-to-r from-yellow-50 to-red-50 p-4 rounded-lg border">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            🎯 Rachas con Formato (Aciertos/Total)
                                        </h3>

                                        <!-- First to Score -->
                                        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
                                            <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                                ⚽ Primero en Marcar
                                            </h4>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label for="away_first_to_score_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Aciertos
                                                    </label>
                                                    <input type="number" name="away_first_to_score_success" id="away_first_to_score_success"
                                                           min="0" value="{{ old('away_first_to_score_success') }}"
                                                           placeholder="opcional"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    @error('away_first_to_score_success')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="away_first_to_score_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Total Partidos
                                                    </label>
                                                    <input type="number" name="away_first_to_score_total" id="away_first_to_score_total"
                                                           min="0" value="{{ old('away_first_to_score_total') }}"
                                                           placeholder="opcional"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    @error('away_first_to_score_total')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500" id="away_first_score_percentage">
                                                Efectividad: -
                                            </div>
                                        </div>

                                        <!-- First Half Winner -->
                                        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
                                            <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                                🏁 Ganador Primer Tiempo
                                            </h4>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label for="away_first_half_winner_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Aciertos
                                                    </label>
                                                    <input type="number" name="away_first_half_winner_success" id="away_first_half_winner_success"
                                                           min="0" value="{{ old('away_first_half_winner_success') }}"
                                                           placeholder="opcional"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    @error('away_first_half_winner_success')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="away_first_half_winner_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Total Partidos
                                                    </label>
                                                    <input type="number" name="away_first_half_winner_total" id="away_first_half_winner_total"
                                                           min="0" value="{{ old('away_first_half_winner_total') }}"
                                                           placeholder="opcional"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    @error('away_first_half_winner_total')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500" id="away_first_half_winner_percentage">
                                                Efectividad: -
                                            </div>
                                        </div>

                                        <!-- Both Teams Score -->
                                        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
                                            <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                                ⚽⚽ Ambos Equipos Anotan
                                            </h4>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label for="away_both_teams_score_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Aciertos
                                                    </label>
                                                    <input type="number" name="away_both_teams_score_success" id="away_both_teams_score_success"
                                                           min="0" value="{{ old('away_both_teams_score_success') }}"
                                                           placeholder="opcional"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    @error('away_both_teams_score_success')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="away_both_teams_score_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Total Partidos
                                                    </label>
                                                    <input type="number" name="away_both_teams_score_total" id="away_both_teams_score_total"
                                                           min="0" value="{{ old('away_both_teams_score_total') }}"
                                                           placeholder="opcional"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    @error('away_both_teams_score_total')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500" id="away_both_teams_percentage">
                                                Efectividad: -
                                            </div>
                                        </div>

                                        <!-- Over 2.5 Goals -->
                                        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
                                            <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                                📈 Más de 2.5 Goles
                                            </h4>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label for="away_over_25_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Aciertos
                                                    </label>
                                                    <input type="number" name="away_over_25_success" id="away_over_25_success"
                                                           min="0" value="{{ old('away_over_25_success') }}"
                                                           placeholder="opcional"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    @error('away_over_25_success')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="away_over_25_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Total Partidos
                                                    </label>
                                                    <input type="number" name="away_over_25_total" id="away_over_25_total"
                                                           min="0" value="{{ old('away_over_25_total') }}"
                                                           placeholder="opcional"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    @error('away_over_25_total')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500" id="away_over_25_percentage">
                                                Efectividad: -
                                            </div>
                                        </div>

                                        <!-- Under 2.5 Goals -->
                                        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
                                            <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                                📉 Menos de 2.5 Goles
                                            </h4>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label for="away_under_25_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Aciertos
                                                    </label>
                                                    <input type="number" name="away_under_25_success" id="away_under_25_success"
                                                           min="0" value="{{ old('away_under_25_success') }}"
                                                           placeholder="opcional"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    @error('away_under_25_success')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="away_under_25_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Total Partidos
                                                    </label>
                                                    <input type="number" name="away_under_25_total" id="away_under_25_total"
                                                           min="0" value="{{ old('away_under_25_total') }}"
                                                           placeholder="opcional"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    @error('away_under_25_total')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500" id="away_under_25_percentage">
                                                Efectividad: -
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="flex justify-between mt-8">
                                    <a href="{{ route('matches.create.step3') }}"
                                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                        ← Volver
                                    </a>
                                    <button type="submit"
                                            class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                        Siguiente: Cuotas →
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Information Panel -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                📊 Información del Paso 4
                            </h3>
                            <div class="space-y-3 text-sm text-gray-600">
                                <p>
                                    <strong>Estadísticas Generales:</strong> Rendimiento del equipo considerando todos sus partidos (local y visitante).
                                </p>
                                <p>
                                    <strong>Dos Tipos de Formato:</strong>
                                </p>
                                <ul class="ml-4 space-y-1">
                                    <li>• <strong>Rachas Simples:</strong> Número de partidos consecutivos (ej: 2 victorias seguidas)</li>
                                    <li>• <strong>Rachas con Ratio:</strong> Aciertos/Total (ej: 6 de 8 partidos = 75%)</li>
                                </ul>
                            </div>

                            <div class="mt-6 p-4 bg-green-100 rounded-lg">
                                <h4 class="font-semibold text-green-800 mb-2">💡 Ejemplo Rachas Simples</h4>
                                <div class="text-sm text-green-700 space-y-2">
                                    <div><strong>Victorias:</strong> 2 (2 victorias consecutivas)</div>
                                    <div><strong>Derrotas:</strong> 1 (1 derrota reciente)</div>
                                    <div><strong>Sin Derrotas:</strong> 4 (4 partidos sin perder)</div>
                                    <div><strong>Ninguna Portería a Cero:</strong> 3 (3 partidos sin portería imbatida)</div>
                                </div>
                            </div>

                            <div class="mt-4 p-4 bg-purple-100 rounded-lg">
                                <h4 class="font-semibold text-purple-800 mb-2">🎯 Ejemplo Rachas con Ratio</h4>
                                <div class="text-sm text-purple-700 space-y-2">
                                    <div><strong>Primero en Marcar:</strong> 6/8 = 75%</div>
                                    <div><strong>1T Ganador:</strong> 4/8 = 50%</div>
                                    <div><strong>Ambos Anotan:</strong> 5/10 = 50%</div>
                                    <div><strong>Más de 2.5:</strong> 3/8 = 37.5%</div>
                                    <div><strong>Menos de 2.5:</strong> 5/8 = 62.5%</div>
                                </div>
                            </div>

                            <div class="mt-4 p-4 bg-blue-100 rounded-lg">
                                <h4 class="font-semibold text-blue-800 mb-2">📋 Consideraciones</h4>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li>• Todos los partidos del equipo (no solo local/visitante)</li>
                                    <li>• Últimos 8-12 partidos recomendado</li>
                                    <li>• <strong>Todos los campos son opcionales</strong> - deja vacío si no hay racha</li>
                                    <li>• Solo llena los campos donde el equipo tenga rachas activas</li>
                                    <li>• Rachas más largas = mayor confianza en predicción</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculatePercentage(successId, totalId, displayId) {
            const success = parseInt(document.getElementById(successId).value) || 0;
            const total = parseInt(document.getElementById(totalId).value) || 0;
            const display = document.getElementById(displayId);

            if (total > 0 && success >= 0) {
                const percentage = ((success / total) * 100).toFixed(1);
                display.textContent = `Efectividad: ${success}/${total} = ${percentage}%`;

                // Color coding based on effectiveness
                if (percentage >= 80) {
                    display.className = 'mt-2 text-sm text-green-600 font-medium';
                } else if (percentage >= 60) {
                    display.className = 'mt-2 text-sm text-yellow-600 font-medium';
                } else {
                    display.className = 'mt-2 text-sm text-red-600 font-medium';
                }
            } else {
                display.textContent = 'Efectividad: -';
                display.className = 'mt-2 text-sm text-gray-500';
            }
        }

        // Validation: success cannot be greater than total
        function validateInput(successId, totalId) {
            const successInput = document.getElementById(successId);
            const totalInput = document.getElementById(totalId);

            if (successInput && totalInput) {
                successInput.addEventListener('input', function() {
                    const success = parseInt(this.value) || 0;
                    const total = parseInt(totalInput.value) || 0;

                    if (total > 0 && success > total) {
                        this.value = total;
                    }
                });
            }
        }

        // Add event listeners for real-time calculation - First to Score
        ['away_first_to_score_success', 'away_first_to_score_total'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', () => {
                    calculatePercentage('away_first_to_score_success', 'away_first_to_score_total', 'away_first_score_percentage');
                });
            }
        });

        // First Half Winner
        ['away_first_half_winner_success', 'away_first_half_winner_total'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', () => {
                    calculatePercentage('away_first_half_winner_success', 'away_first_half_winner_total', 'away_first_half_winner_percentage');
                });
            }
        });

        // Both Teams Score
        ['away_both_teams_score_success', 'away_both_teams_score_total'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', () => {
                    calculatePercentage('away_both_teams_score_success', 'away_both_teams_score_total', 'away_both_teams_percentage');
                });
            }
        });

        // Over 2.5 Goals
        ['away_over_25_success', 'away_over_25_total'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', () => {
                    calculatePercentage('away_over_25_success', 'away_over_25_total', 'away_over_25_percentage');
                });
            }
        });

        // Under 2.5 Goals
        ['away_under_25_success', 'away_under_25_total'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', () => {
                    calculatePercentage('away_under_25_success', 'away_under_25_total', 'away_under_25_percentage');
                });
            }
        });

        // Apply validation to all ratio pairs
        validateInput('away_first_to_score_success', 'away_first_to_score_total');
        validateInput('away_first_half_winner_success', 'away_first_half_winner_total');
        validateInput('away_both_teams_score_success', 'away_both_teams_score_total');
        validateInput('away_over_25_success', 'away_over_25_total');
        validateInput('away_under_25_success', 'away_under_25_total');
    </script>
</x-app-layout>