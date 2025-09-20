<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Partido - Paso 5: Cuotas de Mercados') }}
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
                                Paso 5 de 6
                            </span>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                            <div style="width:83.33%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                        </div>
                    </div>

                    <!-- Match Info -->
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-4 rounded-lg mb-6">
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
                            <form method="POST" action="{{ route('matches.create.step5.store') }}" id="step5Form">
                                @csrf

                                <div class="space-y-6">
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">
                                                    <strong>Opcional:</strong> Si no tienes las cuotas de algún mercado, déjalo vacío. El algoritmo solo evaluará los mercados con cuotas disponibles.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach($markets as $market)
                                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                                            <div class="flex items-center justify-between mb-4">
                                                <div>
                                                    <h3 class="font-semibold text-gray-800 flex items-center">
                                                        {{ $market->icon }} {{ $market->name }}
                                                    </h3>
                                                    <p class="text-sm text-gray-600 mt-1">{{ $market->description }}</p>
                                                </div>
                                                <div class="text-right">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $market->key }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 gap-4">
                                                <div>
                                                    <label for="{{ $market->key }}_odds" class="block text-sm font-medium text-gray-700 mb-2">
                                                        💰 Cuota disponible
                                                    </label>
                                                    <div class="relative">
                                                        <input type="number" name="{{ $market->key }}_odds" id="{{ $market->key }}_odds"
                                                               min="1.01" max="50" step="0.01"
                                                               value="{{ old($market->key . '_odds') }}"
                                                               placeholder="Ej: 1.85"
                                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-12">
                                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 sm:text-sm">cuota</span>
                                                        </div>
                                                    </div>
                                                    @error($market->key . '_odds')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror

                                                    <!-- Value indicator -->
                                                    <div class="mt-2 text-xs" id="{{ $market->key }}_value_indicator">
                                                        <span class="text-gray-500">Introduce la cuota para ver el análisis de valor</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Summary -->
                                <div class="bg-gray-50 p-4 rounded-lg mt-6">
                                    <h3 class="font-semibold text-gray-800 mb-2">📊 Resumen de Cuotas</h3>
                                    <div id="odds_summary" class="text-sm text-gray-600">
                                        <p>Mercados con cuotas: <span id="markets_count">0</span></p>
                                        <p class="text-xs mt-1">El algoritmo evaluará solo los mercados con cuotas disponibles</p>
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="flex justify-between mt-8">
                                    <a href="{{ route('matches.create.step4') }}"
                                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                        ← Volver
                                    </a>
                                    <button type="submit"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Analizar Partido 🔍
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Information Panel -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                💰 Información del Paso 5
                            </h3>
                            <div class="space-y-3 text-sm text-gray-600">
                                <p>
                                    <strong>Cuotas de Mercados:</strong> Introduce las cuotas disponibles en tu casa de apuestas para cada mercado.
                                </p>
                                <p>
                                    <strong>Evaluación de Valor:</strong> El algoritmo comparará las cuotas con las probabilidades calculadas para encontrar oportunidades.
                                </p>
                            </div>

                            <div class="mt-6 p-4 bg-green-100 rounded-lg">
                                <h4 class="font-semibold text-green-800 mb-2">💡 Ejemplo de Cuotas</h4>
                                <div class="text-sm text-green-700 space-y-1">
                                    <div><strong>1X2 Local:</strong> 1.85</div>
                                    <div><strong>Primer Gol Local:</strong> 2.10</div>
                                    <div><strong>1T Ganador Local:</strong> 2.25</div>
                                    <div><strong>Ambos Anotan Sí:</strong> 1.75</div>
                                </div>
                            </div>

                            <div class="mt-4 p-4 bg-blue-100 rounded-lg">
                                <h4 class="font-semibold text-blue-800 mb-2">📋 Consejos</h4>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li>• Compara cuotas entre diferentes casas</li>
                                    <li>• Cuotas más altas = mayor valor potencial</li>
                                    <li>• Solo completa los mercados que planeas evaluar</li>
                                    <li>• El algoritmo priorizará por valor esperado</li>
                                </ul>
                            </div>

                            <div class="mt-4 p-4 bg-yellow-100 rounded-lg">
                                <h4 class="font-semibold text-yellow-800 mb-2">⚡ Indicadores de Valor</h4>
                                <div class="text-sm text-yellow-700 space-y-1">
                                    <div class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>Excelente valor (cuota alta)</div>
                                    <div class="flex items-center"><span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>Valor moderado</div>
                                    <div class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>Valor bajo (cuota baja)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateOddsAnalysis() {
            let marketsWithOdds = 0;
            const marketsContainer = document.querySelectorAll('input[name$="_odds"]');

            marketsContainer.forEach(input => {
                const value = parseFloat(input.value) || 0;
                const marketKey = input.name.replace('_odds', '');
                const indicator = document.getElementById(marketKey + '_value_indicator');

                if (value > 0) {
                    marketsWithOdds++;

                    // Simple value analysis based on odds range
                    let valueClass = '';
                    let valueText = '';

                    if (value >= 2.5) {
                        valueClass = 'text-green-600 font-medium';
                        valueText = `🟢 Cuota alta (${value}) - Valor potencial excelente`;
                    } else if (value >= 1.8) {
                        valueClass = 'text-yellow-600 font-medium';
                        valueText = `🟡 Cuota moderada (${value}) - Valor aceptable`;
                    } else if (value >= 1.3) {
                        valueClass = 'text-orange-600 font-medium';
                        valueText = `🟠 Cuota baja (${value}) - Valor limitado`;
                    } else {
                        valueClass = 'text-red-600 font-medium';
                        valueText = `🔴 Cuota muy baja (${value}) - Poco valor`;
                    }

                    indicator.innerHTML = `<span class="${valueClass}">${valueText}</span>`;
                } else {
                    indicator.innerHTML = '<span class="text-gray-500">Introduce la cuota para ver el análisis de valor</span>';
                }
            });

            // Update summary
            document.getElementById('markets_count').textContent = marketsWithOdds;

            // Update summary color
            const summaryElement = document.getElementById('odds_summary');
            if (marketsWithOdds >= 3) {
                summaryElement.className = 'text-sm text-green-600';
            } else if (marketsWithOdds >= 1) {
                summaryElement.className = 'text-sm text-yellow-600';
            } else {
                summaryElement.className = 'text-sm text-gray-600';
            }
        }

        // Add event listeners to all odds inputs
        document.querySelectorAll('input[name$="_odds"]').forEach(input => {
            input.addEventListener('input', updateOddsAnalysis);
        });

        // Validation for odds range
        document.querySelectorAll('input[name$="_odds"]').forEach(input => {
            input.addEventListener('blur', function() {
                const value = parseFloat(this.value);
                if (value && (value < 1.01 || value > 50)) {
                    alert('Las cuotas deben estar entre 1.01 y 50.00');
                    this.focus();
                }
            });
        });

        // Initial analysis
        updateOddsAnalysis();

        // Form submission validation
        document.getElementById('step5Form').addEventListener('submit', function(e) {
            const hasAnyOdds = Array.from(document.querySelectorAll('input[name$="_odds"]'))
                .some(input => parseFloat(input.value) > 0);

            if (!hasAnyOdds) {
                if (!confirm('No has introducido ninguna cuota. ¿Deseas continuar con el análisis sin cuotas? El algoritmo no podrá evaluar valor.')) {
                    e.preventDefault();
                }
            }
        });
    </script>
</x-app-layout>