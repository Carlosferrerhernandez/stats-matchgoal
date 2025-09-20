<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard - MatchGoal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg mb-8">
                <div class="p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">¡Bienvenido, {{ auth()->user()->name }}!</h1>
                            <p class="text-blue-100">Sistema de predicciones deportivas con IA avanzada</p>
                        </div>
                        <div class="text-6xl opacity-20">⚽</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Create Match -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <span class="text-2xl">🆕</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Crear Partido</h3>
                        <p class="text-gray-600 text-sm mb-4">Analiza un nuevo partido y genera predicciones automáticas</p>
                        <a href="{{ route('matches.create.index') }}"
                           class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition-colors text-center block">
                            Comenzar Análisis
                        </a>
                    </div>
                </div>

                <!-- View Predictions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0V5a2 2 0 012-2h2a2 2 0 00-2-2m0 0V9a2 2 0 012-2h2a2 2 0 00-2-2"/>
                                </svg>
                            </div>
                            <span class="text-2xl">📊</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Mis Predicciones</h3>
                        <p class="text-gray-600 text-sm mb-4">Revisa todas tus predicciones y resultados</p>
                        <a href="{{ route('predictions') }}"
                           class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition-colors text-center block">
                            Ver Predicciones
                        </a>
                    </div>
                </div>

                <!-- Manage Leagues -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <span class="text-2xl">🏆</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Gestionar Ligas</h3>
                        <p class="text-gray-600 text-sm mb-4">Administra las competiciones y equipos</p>
                        <a href="{{ route('leagues.index') }}"
                           class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded transition-colors text-center block">
                            Ir a Ligas
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                @php
                    $totalPredictions = auth()->user()->predictions()->count();
                    $pendingPredictions = auth()->user()->predictions()->where('status', 'pending')->count();
                    $wonPredictions = auth()->user()->predictions()->where('status', 'won')->count();
                    $lostPredictions = auth()->user()->predictions()->where('status', 'lost')->count();
                @endphp

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $totalPredictions }}</div>
                        <div class="text-sm text-gray-600">Total Predicciones</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $pendingPredictions }}</div>
                        <div class="text-sm text-gray-600">Pendientes</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $wonPredictions }}</div>
                        <div class="text-sm text-gray-600">Ganadas</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-red-600">{{ $lostPredictions }}</div>
                        <div class="text-sm text-gray-600">Perdidas</div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">📈 Actividad Reciente</h3>

                    @php
                        $recentPredictions = auth()->user()->predictions()
                            ->with(['match.homeTeam', 'match.awayTeam', 'market'])
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($recentPredictions->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentPredictions as $prediction)
                                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white
                                            {{ $prediction->status === 'won' ? 'bg-green-500' :
                                               ($prediction->status === 'lost' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                            {{ $prediction->status === 'won' ? '✓' :
                                               ($prediction->status === 'lost' ? '✗' : '⏳') }}
                                        </div>
                                        <div>
                                            <div class="font-medium">
                                                {{ $prediction->match->homeTeam->name }} vs {{ $prediction->match->awayTeam->name }}
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                {{ $prediction->market->name }} - {{ $prediction->prediction }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-medium">{{ $prediction->confidence_score }}%</div>
                                        <div class="text-sm text-gray-600">Stake {{ $prediction->suggested_stake }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ route('predictions') }}"
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                Ver todas las predicciones →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <div class="text-4xl mb-4">🎯</div>
                            <p class="mb-4">Aún no tienes predicciones</p>
                            <a href="{{ route('matches.create.index') }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Crear tu primera predicción
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
