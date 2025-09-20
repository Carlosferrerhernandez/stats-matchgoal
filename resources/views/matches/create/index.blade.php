<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Partido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Hero Section -->
                    <div class="text-center mb-12">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0V5a2 2 0 012-2h2a2 2 0 00-2-2m0 0V9a2 2 0 012-2h2a2 2 0 00-2-2"/>
                            </svg>
                        </div>

                        <h1 class="text-4xl font-bold text-gray-900 mb-4">Crear Nuevo Partido</h1>
                        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                            Utiliza nuestro algoritmo avanzado para generar predicciones precisas basadas en estadísticas y rachas de equipos.
                        </p>
                    </div>

                    <!-- Process Overview -->
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">📋 Proceso de Análisis en 6 Pasos</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Step 1 -->
                            <div class="bg-white rounded-lg p-6 border border-blue-200 hover:shadow-lg transition-shadow">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-3">1</div>
                                    <h3 class="font-semibold text-gray-800">Liga y Equipos</h3>
                                </div>
                                <p class="text-sm text-gray-600">Selecciona la competición, equipos y fecha del partido.</p>
                                <div class="mt-3 text-xs text-blue-600">⚽ Configuración básica</div>
                            </div>

                            <!-- Step 2 -->
                            <div class="bg-white rounded-lg p-6 border border-green-200 hover:shadow-lg transition-shadow">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold mr-3">2</div>
                                    <h3 class="font-semibold text-gray-800">Porcentajes</h3>
                                </div>
                                <p class="text-sm text-gray-600">Define las probabilidades de victoria para cada resultado.</p>
                                <div class="mt-3 text-xs text-green-600">📊 Local, Empate, Visitante</div>
                            </div>

                            <!-- Step 3 -->
                            <div class="bg-white rounded-lg p-6 border border-yellow-200 hover:shadow-lg transition-shadow">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center font-bold mr-3">3</div>
                                    <h3 class="font-semibold text-gray-800">Rachas Local</h3>
                                </div>
                                <p class="text-sm text-gray-600">Estadísticas y rachas del equipo que juega en casa.</p>
                                <div class="mt-3 text-xs text-yellow-600">🏠 Primer gol, 1T ganador, etc.</div>
                            </div>

                            <!-- Step 4 -->
                            <div class="bg-white rounded-lg p-6 border border-purple-200 hover:shadow-lg transition-shadow">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center font-bold mr-3">4</div>
                                    <h3 class="font-semibold text-gray-800">Rachas Visitante</h3>
                                </div>
                                <p class="text-sm text-gray-600">Estadísticas y rachas del equipo visitante.</p>
                                <div class="mt-3 text-xs text-purple-600">✈️ Primer gol contra, 1T perdedor, etc.</div>
                            </div>

                            <!-- Step 5 -->
                            <div class="bg-white rounded-lg p-6 border border-indigo-200 hover:shadow-lg transition-shadow">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center font-bold mr-3">5</div>
                                    <h3 class="font-semibold text-gray-800">Cuotas</h3>
                                </div>
                                <p class="text-sm text-gray-600">Introduce las cuotas disponibles para cada mercado.</p>
                                <div class="mt-3 text-xs text-indigo-600">💰 Análisis de valor</div>
                            </div>

                            <!-- Step 6 -->
                            <div class="bg-white rounded-lg p-6 border border-green-200 hover:shadow-lg transition-shadow">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold mr-3">6</div>
                                    <h3 class="font-semibold text-gray-800">Análisis</h3>
                                </div>
                                <p class="text-sm text-gray-600">Resultado final con predicción y stake sugerido.</p>
                                <div class="mt-3 text-xs text-green-600">🎯 Predicción automática</div>
                            </div>
                        </div>
                    </div>

                    <!-- Algorithm Info -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-blue-800 mb-4 flex items-center">
                                🧠 Algoritmo Inteligente
                            </h3>
                            <ul class="space-y-2 text-blue-700">
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                                    Analiza 4 mercados principales de apuestas
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                                    Evalúa rachas y tendencias estadísticas
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                                    Calcula confianza y stake automáticamente
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                                    Sistema configurable en pesos colombianos
                                </li>
                            </ul>
                        </div>

                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-green-800 mb-4 flex items-center">
                                📈 Mercados Analizados
                            </h3>
                            <div class="space-y-2 text-green-700">
                                <div class="flex items-center">
                                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 text-xs">🏆</span>
                                    <span><strong>1X2:</strong> Resultado final del partido</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 text-xs">⚽</span>
                                    <span><strong>Primer Gol:</strong> Qué equipo marca primero</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 text-xs">🏁</span>
                                    <span><strong>1T Ganador:</strong> Resultado al descanso</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 text-xs">⚽⚽</span>
                                    <span><strong>Ambos Anotan:</strong> Si ambos equipos marcan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success Stories -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                        <h3 class="text-lg font-bold text-yellow-800 mb-4 flex items-center">
                            ⭐ Sistema Probado - 5+ Años de Experiencia
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-yellow-700">
                            <div class="text-center">
                                <div class="text-2xl font-bold">5+</div>
                                <div class="text-sm">Años de experiencia</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold">4</div>
                                <div class="text-sm">Mercados especializados</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold">COP</div>
                                <div class="text-sm">Sistema de stakes local</div>
                            </div>
                        </div>
                        <p class="text-center text-yellow-700 mt-4 text-sm">
                            Metodología desarrollada por un apostador profesional con historial comprobado.
                        </p>
                    </div>

                    <!-- Start Button -->
                    <div class="text-center">
                        <a href="{{ route('matches.create.step1') }}"
                           class="inline-flex items-center bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Comenzar Análisis
                        </a>

                        <p class="text-sm text-gray-500 mt-4">
                            El proceso toma aproximadamente 5-10 minutos
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div class="mt-12 border-t pt-8">
                        <div class="flex justify-center space-x-6">
                            <a href="{{ route('predictions') }}"
                               class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0V5a2 2 0 012-2h2a2 2 0 00-2-2m0 0V9a2 2 0 012-2h2a2 2 0 00-2-2"/>
                                </svg>
                                Ver Predicciones
                            </a>

                            <a href="{{ route('leagues.index') }}"
                               class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Gestionar Ligas
                            </a>

                            <a href="{{ route('teams.index') }}"
                               class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Gestionar Equipos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>