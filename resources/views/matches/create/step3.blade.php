<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Partido - Paso 3: Rachas Equipo Local') }}
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
                                Paso 3 de 6
                            </span>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                            <div style="width:50%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                        </div>
                    </div>

                    <!-- Team Info -->
                    <div class="bg-blue-50 p-4 rounded-lg mb-6">
                        <div class="flex justify-center items-center">
                            <div class="text-center">
                                <div class="font-bold text-xl text-blue-800">🏠 {{ $homeTeam->name }}</div>
                                <div class="text-sm text-blue-600">Equipo Local - Rachas y Estadísticas</div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Form Section -->
                        <div>
                            <form method="POST" action="{{ route('matches.create.step3.store') }}" id="step3Form">
                                @csrf

                                <div class="space-y-6">
                                    <!-- First to Score -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            ⚽ Primer Gol (Local)
                                        </h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="home_first_to_score_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Aciertos
                                                </label>
                                                <input type="number" name="home_first_to_score_success" id="home_first_to_score_success"
                                                       min="0" required value="{{ old('home_first_to_score_success') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                @error('home_first_to_score_success')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="home_first_to_score_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Total Partidos
                                                </label>
                                                <input type="number" name="home_first_to_score_total" id="home_first_to_score_total"
                                                       min="1" required value="{{ old('home_first_to_score_total') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                @error('home_first_to_score_total')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-500" id="first_score_percentage">
                                            Efectividad: -
                                        </div>
                                    </div>

                                    <!-- First Half Winner -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            🏁 Ganador Primer Tiempo (Local)
                                        </h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="home_first_half_winner_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Aciertos
                                                </label>
                                                <input type="number" name="home_first_half_winner_success" id="home_first_half_winner_success"
                                                       min="0" required value="{{ old('home_first_half_winner_success') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                @error('home_first_half_winner_success')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="home_first_half_winner_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Total Partidos
                                                </label>
                                                <input type="number" name="home_first_half_winner_total" id="home_first_half_winner_total"
                                                       min="1" required value="{{ old('home_first_half_winner_total') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                @error('home_first_half_winner_total')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-500" id="first_half_percentage">
                                            Efectividad: -
                                        </div>
                                    </div>

                                    <!-- Both Teams Score -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            ⚽⚽ Ambos Equipos Anotan (Partidos del Local)
                                        </h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="home_both_teams_score_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Aciertos
                                                </label>
                                                <input type="number" name="home_both_teams_score_success" id="home_both_teams_score_success"
                                                       min="0" required value="{{ old('home_both_teams_score_success') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                @error('home_both_teams_score_success')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="home_both_teams_score_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Total Partidos
                                                </label>
                                                <input type="number" name="home_both_teams_score_total" id="home_both_teams_score_total"
                                                       min="1" required value="{{ old('home_both_teams_score_total') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                @error('home_both_teams_score_total')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-500" id="both_teams_percentage">
                                            Efectividad: -
                                        </div>
                                    </div>

                                    <!-- No Defeats (Optional) -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            🛡️ Sin Derrotas (Opcional)
                                        </h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="home_no_defeats_success" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Aciertos
                                                </label>
                                                <input type="number" name="home_no_defeats_success" id="home_no_defeats_success"
                                                       min="0" value="{{ old('home_no_defeats_success') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                @error('home_no_defeats_success')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="home_no_defeats_total" class="block text-sm font-medium text-gray-700 mb-1">
                                                    Total Partidos
                                                </label>
                                                <input type="number" name="home_no_defeats_total" id="home_no_defeats_total"
                                                       min="0" value="{{ old('home_no_defeats_total') }}"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                @error('home_no_defeats_total')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-500" id="no_defeats_percentage">
                                            Efectividad: -
                                        </div>
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="flex justify-between mt-8">
                                    <a href="{{ route('matches.create.step2') }}"
                                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                        ← Volver
                                    </a>
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Siguiente: Rachas Visitante →
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Information Panel -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                📊 Información del Paso 3
                            </h3>
                            <div class="space-y-3 text-sm text-gray-600">
                                <p>
                                    <strong>Rachas del Local:</strong> Estadísticas específicas del equipo que juega en casa para los últimos partidos.
                                </p>
                                <p>
                                    <strong>Formato:</strong> Ingresa aciertos/total partidos (ej: 4 aciertos de 5 partidos).
                                </p>
                            </div>

                            <div class="mt-6 p-4 bg-green-100 rounded-lg">
                                <h4 class="font-semibold text-green-800 mb-2">💡 Ejemplo</h4>
                                <div class="text-sm text-green-700 space-y-2">
                                    <div><strong>Primer Gol:</strong> 4/5 = 80%</div>
                                    <div><strong>1T Ganador:</strong> 3/5 = 60%</div>
                                    <div><strong>Ambos Anotan:</strong> 5/5 = 100%</div>
                                    <div><strong>Sin Derrotas:</strong> 7/8 = 87.5%</div>
                                </div>
                            </div>

                            <div class="mt-4 p-4 bg-blue-100 rounded-lg">
                                <h4 class="font-semibold text-blue-800 mb-2">📋 Consideraciones</h4>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li>• Solo partidos como local</li>
                                    <li>• Últimos 5-10 partidos recomendado</li>
                                    <li>• Las rachas opcionales pueden dejarse vacías</li>
                                    <li>• Mayor racha = mayor confianza en predicción</li>
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
        ['home_first_to_score_success', 'home_first_to_score_total'].forEach(id => {
            document.getElementById(id).addEventListener('input', () => {
                calculatePercentage('home_first_to_score_success', 'home_first_to_score_total', 'first_score_percentage');
            });
        });

        ['home_first_half_winner_success', 'home_first_half_winner_total'].forEach(id => {
            document.getElementById(id).addEventListener('input', () => {
                calculatePercentage('home_first_half_winner_success', 'home_first_half_winner_total', 'first_half_percentage');
            });
        });

        ['home_both_teams_score_success', 'home_both_teams_score_total'].forEach(id => {
            document.getElementById(id).addEventListener('input', () => {
                calculatePercentage('home_both_teams_score_success', 'home_both_teams_score_total', 'both_teams_percentage');
            });
        });

        ['home_no_defeats_success', 'home_no_defeats_total'].forEach(id => {
            document.getElementById(id).addEventListener('input', () => {
                calculatePercentage('home_no_defeats_success', 'home_no_defeats_total', 'no_defeats_percentage');
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
        validateInput('home_first_to_score_success', 'home_first_to_score_total');
        validateInput('home_first_half_winner_success', 'home_first_half_winner_total');
        validateInput('home_both_teams_score_success', 'home_both_teams_score_total');
        validateInput('home_no_defeats_success', 'home_no_defeats_total');
    </script>
</x-app-layout>