<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Partido - Paso 2: Porcentajes de Victoria') }}
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
                                Paso 2 de 6
                            </span>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                            <div style="width:33.33%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                        </div>
                    </div>

                    <!-- Match Info -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="flex justify-center items-center space-x-4">
                            <div class="text-center">
                                <div class="font-bold text-lg">{{ $homeTeam->name }}</div>
                                <div class="text-sm text-gray-600">Local</div>
                            </div>
                            <div class="text-2xl font-bold text-gray-400">VS</div>
                            <div class="text-center">
                                <div class="font-bold text-lg">{{ $awayTeam->name }}</div>
                                <div class="text-sm text-gray-600">Visitante</div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Form Section -->
                        <div>
                            <form method="POST" action="{{ route('matches.create.step2.store') }}" id="step2Form">
                                @csrf

                                <div class="space-y-6">
                                    <!-- Home Win Percentage -->
                                    <div>
                                        <label for="home_win_percent" class="block text-sm font-medium text-gray-700 mb-2">
                                            🏠 Porcentaje Victoria Local (%)
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="home_win_percent" id="home_win_percent"
                                                   min="0" max="100" step="0.1" required
                                                   value="{{ old('home_win_percent') }}"
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-8">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">%</span>
                                            </div>
                                        </div>
                                        @error('home_win_percent')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Draw Percentage -->
                                    <div>
                                        <label for="draw_percent" class="block text-sm font-medium text-gray-700 mb-2">
                                            🤝 Porcentaje Empate (%)
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="draw_percent" id="draw_percent"
                                                   min="0" max="100" step="0.1" required
                                                   value="{{ old('draw_percent') }}"
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-8">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">%</span>
                                            </div>
                                        </div>
                                        @error('draw_percent')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Away Win Percentage -->
                                    <div>
                                        <label for="away_win_percent" class="block text-sm font-medium text-gray-700 mb-2">
                                            ✈️ Porcentaje Victoria Visitante (%)
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="away_win_percent" id="away_win_percent"
                                                   min="0" max="100" step="0.1" required
                                                   value="{{ old('away_win_percent') }}"
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-8">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">%</span>
                                            </div>
                                        </div>
                                        @error('away_win_percent')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Total Display -->
                                    <div class="bg-blue-50 p-4 rounded-lg">
                                        <div class="flex justify-between items-center">
                                            <span class="font-medium text-blue-800">Total:</span>
                                            <span id="total_percent" class="font-bold text-blue-800">0%</span>
                                        </div>
                                        <div class="text-xs text-blue-600 mt-1">
                                            Debe sumar exactamente 100%
                                        </div>
                                    </div>

                                    @error('total')
                                        <div class="bg-red-50 border border-red-200 rounded-md p-4">
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="flex justify-between mt-8">
                                    <a href="{{ route('matches.create.step1') }}"
                                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                        ← Volver
                                    </a>
                                    <button type="submit" id="submitBtn"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50 disabled:cursor-not-allowed">
                                        Siguiente: Rachas Local →
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Information Panel -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                📊 Información del Paso 2
                            </h3>
                            <div class="space-y-3 text-sm text-gray-600">
                                <p>
                                    <strong>Porcentajes de Victoria:</strong> Estima la probabilidad de cada resultado basándote en el análisis previo del partido.
                                </p>
                                <p>
                                    <strong>Suma 100%:</strong> Los tres porcentajes deben sumar exactamente 100%.
                                </p>
                            </div>

                            <div class="mt-6 p-4 bg-yellow-100 rounded-lg">
                                <h4 class="font-semibold text-yellow-800 mb-2">💡 Ejemplo</h4>
                                <div class="text-sm text-yellow-700 space-y-1">
                                    <div>Local: <strong>49%</strong></div>
                                    <div>Empate: <strong>26%</strong></div>
                                    <div>Visitante: <strong>25%</strong></div>
                                    <div class="border-t pt-1 mt-1">Total: <strong>100%</strong></div>
                                </div>
                            </div>

                            <div class="mt-4 p-4 bg-green-100 rounded-lg">
                                <h4 class="font-semibold text-green-800 mb-2">📋 Consideraciones</h4>
                                <ul class="text-sm text-green-700 space-y-1">
                                    <li>• Factor campo local (ventaja casa)</li>
                                    <li>• Forma actual de ambos equipos</li>
                                    <li>• Historial de enfrentamientos</li>
                                    <li>• Importancia del partido</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateTotal() {
            const homeWin = parseFloat(document.getElementById('home_win_percent').value) || 0;
            const draw = parseFloat(document.getElementById('draw_percent').value) || 0;
            const awayWin = parseFloat(document.getElementById('away_win_percent').value) || 0;

            const total = homeWin + draw + awayWin;
            const totalElement = document.getElementById('total_percent');
            const submitBtn = document.getElementById('submitBtn');

            totalElement.textContent = total.toFixed(1) + '%';

            // Change color based on total
            if (Math.abs(total - 100) < 0.1) {
                totalElement.className = 'font-bold text-green-600';
                submitBtn.disabled = false;
            } else {
                totalElement.className = 'font-bold text-red-600';
                submitBtn.disabled = true;
            }
        }

        // Add event listeners
        document.getElementById('home_win_percent').addEventListener('input', calculateTotal);
        document.getElementById('draw_percent').addEventListener('input', calculateTotal);
        document.getElementById('away_win_percent').addEventListener('input', calculateTotal);

        // Calculate initial total
        calculateTotal();

        // Auto-adjust percentages to sum 100% (optional helper)
        document.getElementById('away_win_percent').addEventListener('blur', function() {
            const homeWin = parseFloat(document.getElementById('home_win_percent').value) || 0;
            const draw = parseFloat(document.getElementById('draw_percent').value) || 0;
            const awayWin = parseFloat(this.value) || 0;

            const total = homeWin + draw + awayWin;

            if (total !== 100 && total > 0) {
                // Suggest auto-adjustment
                const factor = 100 / total;
                const newHome = (homeWin * factor).toFixed(1);
                const newDraw = (draw * factor).toFixed(1);
                const newAway = (awayWin * factor).toFixed(1);

                if (confirm(`¿Quieres ajustar automáticamente los porcentajes para que sumen 100%?\n\nLocal: ${newHome}%\nEmpate: ${newDraw}%\nVisitante: ${newAway}%`)) {
                    document.getElementById('home_win_percent').value = newHome;
                    document.getElementById('draw_percent').value = newDraw;
                    document.getElementById('away_win_percent').value = newAway;
                    calculateTotal();
                }
            }
        });
    </script>
</x-app-layout>