<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Partido - Paso 1: Liga y Equipos') }}
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
                                Paso 1 de 6
                            </span>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                            <div style="width:16.66%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Form Section -->
                        <div>
                            <form method="POST" action="{{ route('matches.create.step1.store') }}" id="step1Form">
                                @csrf

                                <!-- URL del Partido (Scraping) -->
                                <div class="mb-6">
                                    <label for="match_url" class="block text-sm font-medium text-gray-700 mb-2">
                                        URL del Partido (Opcional)
                                    </label>
                                    <div class="flex gap-2">
                                        <input type="url" name="match_url" id="match_url"
                                               placeholder="https://ejemplo.com/partido-real-madrid-vs-barcelona"
                                               value="{{ old('match_url') }}"
                                               class="flex-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <button type="button" id="scrapeBtn"
                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            📡 Extraer
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Pega la URL del partido para llenar automáticamente los datos
                                    </p>
                                    @error('match_url')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Liga Selection -->
                                <div class="mb-6">
                                    <label for="league_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Liga
                                    </label>
                                    <select name="league_id" id="league_id" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Seleccionar liga...</option>
                                        @foreach($leagues as $league)
                                            <option value="{{ $league->id }}" {{ old('league_id') == $league->id ? 'selected' : '' }}>
                                                {{ $league->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('league_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Home Team Selection -->
                                <div class="mb-6">
                                    <label for="home_team_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Equipo Local
                                    </label>
                                    <select name="home_team_id" id="home_team_id" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Seleccionar equipo local...</option>
                                    </select>
                                    @error('home_team_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Away Team Selection -->
                                <div class="mb-6">
                                    <label for="away_team_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Equipo Visitante
                                    </label>
                                    <select name="away_team_id" id="away_team_id" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Seleccionar equipo visitante...</option>
                                    </select>
                                    @error('away_team_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Match Date -->
                                <div class="mb-6">
                                    <label for="match_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Fecha del Partido
                                    </label>
                                    <input type="date" name="match_date" id="match_date" required
                                           value="{{ old('match_date') }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('match_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="flex justify-between">
                                    <a href="{{ route('matches.create.index') }}"
                                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                        Volver
                                    </a>
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Siguiente: Porcentajes →
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Information Panel -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                📋 Información del Paso 1
                            </h3>
                            <div class="space-y-3 text-sm text-gray-600">
                                <p>
                                    <strong>URL del Partido:</strong> Pega el enlace de sitios deportivos para autocompletar datos.
                                </p>
                                <p>
                                    <strong>Liga:</strong> Selecciona la competición donde se jugará el partido.
                                </p>
                                <p>
                                    <strong>Equipos:</strong> Define qué equipo juega como local y cuál como visitante.
                                </p>
                                <p>
                                    <strong>Fecha:</strong> Programa cuándo se realizará el encuentro.
                                </p>
                            </div>

                            <div class="mt-6 p-4 bg-blue-100 rounded-lg">
                                <h4 class="font-semibold text-blue-800 mb-2">💡 Consejos</h4>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li>• Usa URLs de sitios como Flashscore, Bet365, Marca, AS</li>
                                    <li>• La condición de local/visitante afecta las estadísticas</li>
                                    <li>• Asegúrate de que la fecha sea correcta</li>
                                    <li>• Los equipos deben pertenecer a la liga seleccionada</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Scraping functionality
        document.getElementById('scrapeBtn').addEventListener('click', function() {
            const url = document.getElementById('match_url').value;

            if (!url) {
                alert('Por favor ingresa una URL válida');
                return;
            }

            // Show loading state
            this.disabled = true;
            this.innerHTML = '⏳ Extrayendo...';

            // Call scraping endpoint
            fetch('{{ route('api.scrape-match') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ url: url })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Error: ' + data.error);
                } else {
                    // Fill form with scraped data
                    fillFormWithScrapedData(data);
                    alert('✅ Datos extraídos correctamente');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al extraer los datos. Verifica la URL.');
            })
            .finally(() => {
                // Reset button
                this.disabled = false;
                this.innerHTML = '📡 Extraer';
            });
        });

        function fillFormWithScrapedData(data) {
            // Fill league
            if (data.league_id) {
                document.getElementById('league_id').value = data.league_id;
                document.getElementById('league_id').dispatchEvent(new Event('change'));
            }

            // Fill date
            if (data.match_date) {
                document.getElementById('match_date').value = data.match_date;
            }

            // Wait for teams to load, then fill them
            setTimeout(() => {
                if (data.home_team_id) {
                    document.getElementById('home_team_id').value = data.home_team_id;
                }
                if (data.away_team_id) {
                    document.getElementById('away_team_id').value = data.away_team_id;
                }
            }, 1000);
        }

        // Load teams when league is selected
        document.getElementById('league_id').addEventListener('change', function() {
            const leagueId = this.value;
            const homeTeamSelect = document.getElementById('home_team_id');
            const awayTeamSelect = document.getElementById('away_team_id');

            // Clear current options
            homeTeamSelect.innerHTML = '<option value="">Seleccionar equipo local...</option>';
            awayTeamSelect.innerHTML = '<option value="">Seleccionar equipo visitante...</option>';

            if (leagueId) {
                fetch(`{{ route('api.teams-by-league') }}?league_id=${leagueId}`)
                    .then(response => response.json())
                    .then(teams => {
                        teams.forEach(team => {
                            const homeOption = new Option(team.name, team.id);
                            const awayOption = new Option(team.name, team.id);
                            homeTeamSelect.add(homeOption);
                            awayTeamSelect.add(awayOption.cloneNode(true));
                        });
                    })
                    .catch(error => {
                        console.error('Error loading teams:', error);
                    });
            }
        });

        // Prevent selecting same team for home and away
        document.getElementById('home_team_id').addEventListener('change', function() {
            const homeTeamId = this.value;
            const awayTeamSelect = document.getElementById('away_team_id');

            // Reset away team if same as home
            if (awayTeamSelect.value === homeTeamId) {
                awayTeamSelect.value = '';
            }
        });

        document.getElementById('away_team_id').addEventListener('change', function() {
            const awayTeamId = this.value;
            const homeTeamSelect = document.getElementById('home_team_id');

            // Reset home team if same as away
            if (homeTeamSelect.value === awayTeamId) {
                homeTeamSelect.value = '';
            }
        });
    </script>
</x-app-layout>