<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Predicciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Header Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">📊 Mis Predicciones</h1>
                            <p class="text-gray-600">Historial completo de análisis y resultados</p>
                        </div>
                        <a href="{{ route('matches.create.index') }}"
                           class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            + Crear Nueva Predicción
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                @php
                    $totalPredictions = $predictions->total();
                    $pendingCount = auth()->user()->predictions()->where('status', 'pending')->count();
                    $wonCount = auth()->user()->predictions()->where('status', 'won')->count();
                    $lostCount = auth()->user()->predictions()->where('status', 'lost')->count();
                    $completedPredictions = $wonCount + $lostCount;
                    $winRate = $completedPredictions > 0 ? round(($wonCount / $completedPredictions) * 100, 1) : 0;
                @endphp

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $totalPredictions }}</div>
                        <div class="text-sm text-gray-600">Total</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $pendingCount }}</div>
                        <div class="text-sm text-gray-600">Pendientes</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $wonCount }}</div>
                        <div class="text-sm text-gray-600">Ganadas</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $winRate }}%</div>
                        <div class="text-sm text-gray-600">Efectividad</div>
                    </div>
                </div>
            </div>

            <!-- Predictions List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($predictions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Partido
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Mercado & Predicción
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Confianza & Stake
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Monto
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fecha
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($predictions as $prediction)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $prediction->match->homeTeam->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            vs {{ $prediction->match->awayTeam->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $prediction->market->icon }} {{ $prediction->market->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $prediction->prediction }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $prediction->confidence_score }}%
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    Stake {{ $prediction->suggested_stake }}/4
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                ${{ number_format($prediction->calculateBetAmountCOP(), 0, ',', '.') }}
                                                <div class="text-xs text-gray-500">COP</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'won' => 'bg-green-100 text-green-800',
                                                        'lost' => 'bg-red-100 text-red-800',
                                                        'placed' => 'bg-blue-100 text-blue-800',
                                                        'void' => 'bg-gray-100 text-gray-800'
                                                    ];
                                                    $statusIcons = [
                                                        'pending' => '⏳',
                                                        'won' => '✅',
                                                        'lost' => '❌',
                                                        'placed' => '🎯',
                                                        'void' => '⚪'
                                                    ];
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$prediction->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ $statusIcons[$prediction->status] ?? '?' }}
                                                    {{ ucfirst($prediction->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $prediction->created_at->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $predictions->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">🎯</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay predicciones aún</h3>
                            <p class="text-gray-500 mb-6">Comienza creando tu primera predicción con nuestro algoritmo avanzado</p>
                            <a href="{{ route('matches.create.index') }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg">
                                Crear Primera Predicción
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>