<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Equipo: ' . $team->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            ✏️ Editar Equipo
                        </h1>
                        <p class="text-gray-600 mt-2">Modifica los datos del equipo: {{ $team->name }}</p>
                    </div>

                    <form method="POST" action="{{ route('teams.update', $team) }}">
                        @csrf
                        @method('PUT')

                        <!-- Team Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Equipo *
                            </label>
                            <input type="text" name="name" id="name" required
                                   value="{{ old('name', $team->name) }}"
                                   placeholder="Ej: Real Madrid, FC Barcelona, Manchester United..."
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- League Selection -->
                        <div class="mb-6">
                            <label for="league_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Liga *
                            </label>
                            <select name="league_id" id="league_id" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccionar liga...</option>
                                @foreach($leagues as $league)
                                    <option value="{{ $league->id }}"
                                            {{ old('league_id', $team->league_id) == $league->id ? 'selected' : '' }}>
                                        {{ $league->name }}
                                        @if($league->country)
                                            ({{ $league->country }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('league_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="mb-6">
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                Ciudad
                            </label>
                            <input type="text" name="city" id="city"
                                   value="{{ old('city', $team->city) }}"
                                   placeholder="Ej: Madrid, Barcelona, Manchester..."
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Founded Year -->
                        <div class="mb-6">
                            <label for="founded_year" class="block text-sm font-medium text-gray-700 mb-2">
                                Año de Fundación
                            </label>
                            <input type="number" name="founded_year" id="founded_year"
                                   min="1800" max="{{ date('Y') }}"
                                   value="{{ old('founded_year', $team->founded_year) }}"
                                   placeholder="Ej: 1902, 1899, 1878..."
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('founded_year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      placeholder="Información adicional sobre el equipo..."
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $team->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Stats -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                            <h3 class="font-semibold text-gray-800 mb-2">📊 Estado Actual</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Partidos como local:</span>
                                    <span class="font-medium">{{ $team->homeMatches()->count() }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Partidos como visitante:</span>
                                    <span class="font-medium">{{ $team->awayMatches()->count() }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Estadísticas registradas:</span>
                                    <span class="font-medium">{{ $team->stats()->count() }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Registrado:</span>
                                    <span class="font-medium">{{ $team->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Warning if has matches -->
                        @if($team->homeMatches()->count() > 0 || $team->awayMatches()->count() > 0)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                <h3 class="font-semibold text-yellow-800 mb-2">⚠️ Advertencia</h3>
                                <p class="text-sm text-yellow-700">
                                    Este equipo tiene partidos registrados. Cambiar la liga afectará:
                                </p>
                                <ul class="text-sm text-yellow-700 mt-2 space-y-1">
                                    <li>• Las estadísticas y rachas del equipo</li>
                                    <li>• Los partidos existentes y sus predicciones</li>
                                    <li>• La compatibilidad con otros equipos para futuros partidos</li>
                                </ul>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex justify-between">
                            <a href="{{ route('teams.index') }}"
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Equipo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-blue-800 mb-3">🔗 Acciones Rápidas</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('teams.show', $team) }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                        Ver Detalles
                    </a>
                    <a href="{{ route('leagues.show', $team->league) }}"
                       class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm">
                        Ver Liga
                    </a>
                    @if($team->league->teams()->count() >= 2)
                        <a href="{{ route('matches.create.index', ['league' => $team->league_id, 'team' => $team->id]) }}"
                           class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                            Crear Partido
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>