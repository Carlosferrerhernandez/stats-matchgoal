<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prueba de Scraping - SofaScore') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('test.scraping.test') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="url" class="block text-sm font-medium text-gray-700">URL de SofaScore</label>
                            <input type="url"
                                   name="url"
                                   id="url"
                                   value="https://www.sofascore.com/es/football/match/chelsea-manchester-united/mcYb#id:14025169"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="https://www.sofascore.com/es/football/match/...">
                        </div>

                        <div>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Probar Scraping con ScrapeOps
                            </button>
                        </div>
                    </form>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">URLs de Ejemplo (con Event ID):</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><strong>Chelsea vs Manchester United:</strong> https://www.sofascore.com/es/football/match/chelsea-manchester-united/mcYb#id:14025169</li>
                            <li><strong>Real Madrid vs Barcelona:</strong> https://www.sofascore.com/es/football/match/real-madrid-barcelona/qJbxZgb#id:14025170</li>
                            <li><strong>Manchester City vs Arsenal:</strong> https://www.sofascore.com/es/football/match/manchester-city-arsenal/xJbxZgb#id:14025171</li>
                        </ul>

                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <strong>Importante:</strong> Para obtener datos reales de rachas y estadísticas, asegúrate de que la URL incluya el <code>#id:NUMERO</code> al final.
                                Esto permite al sistema acceder a las APIs específicas de SofaScore.
                            </p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información Técnica:</h3>
                        <div class="bg-gray-50 rounded-lg p-4 text-sm">
                            <ul class="space-y-1">
                                <li><strong>ScrapeOps:</strong> Configurado con proxies residenciales</li>
                                <li><strong>APIs SofaScore:</strong> Acceso directo a endpoints específicos</li>
                                <li><strong>Datos extraídos:</strong> Forma reciente, rachas reales, cuotas en vivo</li>
                                <li><strong>Rachas calculadas:</strong> Basadas en últimos 10 partidos del equipo</li>
                                <li><strong>Fallback:</strong> HTML scraping si las APIs fallan</li>
                            </ul>
                        </div>

                        <div class="mt-4">
                            <h4 class="text-md font-medium text-gray-800 mb-2">Datos que se extraen:</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <strong>Rachas Simples:</strong>
                                    <ul class="ml-4 list-disc">
                                        <li>Racha de victorias</li>
                                        <li>Racha de derrotas</li>
                                        <li>Racha sin derrotas</li>
                                        <li>Racha sin portería a cero</li>
                                    </ul>
                                </div>
                                <div>
                                    <strong>Ratios X/Y:</strong>
                                    <ul class="ml-4 list-disc">
                                        <li>Primero en marcar</li>
                                        <li>Ganador primer tiempo</li>
                                        <li>Ambos equipos anotan</li>
                                        <li>Más/Menos de 2.5 goles</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>