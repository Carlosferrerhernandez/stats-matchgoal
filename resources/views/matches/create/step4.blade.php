<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Partido - Paso 4: Rachas Equipo Visitante') }}
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
                                <div class="text-sm text-purple-600">Equipo Visitante - Rachas y Estadísticas</div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Form Section -->
                        <div>
                            <form method="POST" action="{{ route('matches.create.step4.store') }}" id="step4Form">
                                @csrf

                                <div class="space-y-6">
                                    <!-- First to Score (Away) -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            ⚽ Primer Gol (Visitante)
                                        </h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="away_first_to_score_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Aciertos
                                                </label>
                                                <input type="number" name="away_first_to_score_success" id="away_first_to_score_success"
                                                       min="0" required value="{{ old('away_first_to_score_success') }}"
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
                                                       min="1" required value="{{ old('away_first_to_score_total') }}"
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

                                    <!-- First to Concede (Away) -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            🥅 Primer Gol en Contra (Visitante)
                                        </h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="away_first_to_concede_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Aciertos
                                                </label>
                                                <input type="number" name="away_first_to_concede_success" id="away_first_to_concede_success"
                                                       min="0" required value="{{ old('away_first_to_concede_success') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                @error('away_first_to_concede_success')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="away_first_to_concede_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Total Partidos
                                                </label>
                                                <input type="number" name="away_first_to_concede_total" id="away_first_to_concede_total"
                                                       min="1" required value="{{ old('away_first_to_concede_total') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                @error('away_first_to_concede_total')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-500" id="away_first_concede_percentage">
                                            Efectividad: -
                                        </div>
                                    </div>

                                    <!-- First Half Winner (Away) -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            🏁 Ganador Primer Tiempo (Visitante)
                                        </h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="away_first_half_winner_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Aciertos
                                                </label>
                                                <input type="number" name="away_first_half_winner_success" id="away_first_half_winner_success"
                                                       min="0" required value="{{ old('away_first_half_winner_success') }}"
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
                                                       min="1" required value="{{ old('away_first_half_winner_total') }}"
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

                                    <!-- First Half Loser (Away) -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            📉 Perdedor Primer Tiempo (Visitante)
                                        </h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="away_first_half_loser_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Aciertos
                                                </label>
                                                <input type="number" name="away_first_half_loser_success" id="away_first_half_loser_success"
                                                       min="0" required value="{{ old('away_first_half_loser_success') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                @error('away_first_half_loser_success')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="away_first_half_loser_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Total Partidos
                                                </label>
                                                <input type="number" name="away_first_half_loser_total" id="away_first_half_loser_total"
                                                       min="1" required value="{{ old('away_first_half_loser_total') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                @error('away_first_half_loser_total')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-500" id="away_first_half_loser_percentage">
                                            Efectividad: -
                                        </div>
                                    </div>

                                    <!-- Both Teams Score (Away) -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            ⚽⚽ Ambos Equipos Anotan (Partidos del Visitante)
                                        </h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="away_both_teams_score_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Aciertos
                                                </label>
                                                <input type="number" name="away_both_teams_score_success" id="away_both_teams_score_success"
                                                       min="0" required value="{{ old('away_both_teams_score_success') }}"
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
                                                       min="1" required value="{{ old('away_both_teams_score_total') }}"
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

                                    <!-- No Wins (Optional) -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            📉 Sin Victorias (Opcional)
                                        </h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="away_no_wins_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Aciertos
                                                </label>
                                                <input type="number" name="away_no_wins_success" id="away_no_wins_success"
                                                       min="0" value="{{ old('away_no_wins_success') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                @error('away_no_wins_success')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="away_no_wins_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Total Partidos
                                                </label>
                                                <input type="number" name="away_no_wins_total" id="away_no_wins_total"
                                                       min="0" value="{{ old('away_no_wins_total') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                @error('away_no_wins_total')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-500" id="away_no_wins_percentage">
                                            Efectividad: -
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
                                    <strong>Rachas del Visitante:</strong> Estadísticas específicas del equipo visitante para los últimos partidos jugados fuera de casa.
                                </p>
                                <p>
                                    <strong>Estadísticas Adicionales:</strong> Incluye rachas como "primer gol en contra" y "perdedor del primer tiempo".
                                </p>
                            </div>

                            <div class="mt-6 p-4 bg-purple-100 rounded-lg">
                                <h4 class="font-semibold text-purple-800 mb-2">💡 Ejemplo</h4>
                                <div class="text-sm text-purple-700 space-y-2">
                                    <div><strong>Primer Gol:</strong> 2/5 = 40%</div>
                                    <div><strong>1er Gol Contra:</strong> 4/5 = 80%</div>
                                    <div><strong>1T Ganador:</strong> 1/5 = 20%</div>
                                    <div><strong>1T Perdedor:</strong> 3/5 = 60%</div>
                                    <div><strong>Ambos Anotan:</strong> 4/5 = 80%</div>
                                </div>
                            </div>

                            <div class="mt-4 p-4 bg-yellow-100 rounded-lg">
                                <h4 class="font-semibold text-yellow-800 mb-2">📋 Consideraciones</h4>
                                <ul class="text-sm text-yellow-700 space-y-1">
                                    <li>• Solo partidos como visitante</li>
                                    <li>• Las rachas de visitante suelen ser menores</li>
                                    <li>• "Primer gol en contra" es importante para underdog</li>
                                    <li>• Factor desventaja por jugar fuera de casa</li>
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

            if (total > 0) {
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

        // Add event listeners for real-time calculation
        const streakPairs = [
            ['away_first_to_score_success', 'away_first_to_score_total', 'away_first_score_percentage'],
            ['away_first_to_concede_success', 'away_first_to_concede_total', 'away_first_concede_percentage'],
            ['away_first_half_winner_success', 'away_first_half_winner_total', 'away_first_half_winner_percentage'],
            ['away_first_half_loser_success', 'away_first_half_loser_total', 'away_first_half_loser_percentage'],
            ['away_both_teams_score_success', 'away_both_teams_score_total', 'away_both_teams_percentage'],
            ['away_no_wins_success', 'away_no_wins_total', 'away_no_wins_percentage']
        ];

        streakPairs.forEach(([successId, totalId, displayId]) => {
            [successId, totalId].forEach(id => {
                document.getElementById(id).addEventListener('input', () => {
                    calculatePercentage(successId, totalId, displayId);
                });
            });
        });

        // Validation: success cannot be greater than total
        function validateInput(successId, totalId) {
            const successInput = document.getElementById(successId);
            const totalInput = document.getElementById(totalId);

            successInput.addEventListener('input', function() {
                const success = parseInt(this.value) || 0;
                const total = parseInt(totalInput.value) || 0;

                if (total > 0 && success > total) {
                    this.value = total;
                }
            });
        }

        // Apply validation to all pairs
        streakPairs.forEach(([successId, totalId]) => {
            validateInput(successId, totalId);
        });
    </script>
</x-app-layout>