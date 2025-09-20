<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Equipo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            ⚽ Crear Nuevo Equipo
                        </h1>
                        <p class="text-gray-600 mt-2">Registra un nuevo equipo en el sistema</p>
                    </div>

                    <form method="POST" action="{{ route('teams.store') }}">
                        @csrf

                        <!-- Team Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Equipo *
                            </label>
                            <input type="text" name="name" id="name" required
                                   value="{{ old('name') }}"
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
                                            {{ old('league_id', request('league')) == $league->id ? 'selected' : '' }}>
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
                                   value="{{ old('city') }}"
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
                                   value="{{ old('founded_year') }}"
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
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Information Panel -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <h3 class="font-semibold text-blue-800 mb-2">📋 Información</h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• El nombre del equipo debe ser único en su liga</li>
                                <li>• Todos los campos excepto nombre y liga son opcionales</li>
                                <li>• Podrás editar esta información más tarde</li>
                                <li>• El equipo estará disponible para crear partidos inmediatamente</li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between">
                            <a href="{{ route('teams.index') }}"
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Crear Equipo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-semibold text-green-800 mb-2">⚡ Acciones Rápidas</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('leagues.create') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                        + Nueva Liga
                    </a>
                    <a href="{{ route('leagues.index') }}"
                       class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm">
                        Ver Ligas
                    </a>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h3 class="font-semibold text-yellow-800 mb-2">✅ Próximos Pasos</h3>
                <p class="text-sm text-yellow-700">
                    Después de crear el equipo, podrás:
                </p>
                <ul class="text-sm text-yellow-700 mt-2 space-y-1">
                    <li>• Crear partidos contra otros equipos de la misma liga</li>
                    <li>• Registrar estadísticas y rachas del equipo</li>
                    <li>• Generar predicciones automáticas para sus partidos</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>