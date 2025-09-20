<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Liga: ' . $league->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            ✏️ Editar Liga
                        </h1>
                        <p class="text-gray-600 mt-2">Modifica los datos de la liga: {{ $league->name }}</p>
                    </div>

                    <form method="POST" action="{{ route('leagues.update', $league) }}">
                        @csrf
                        @method('PUT')

                        <!-- League Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre de la Liga *
                            </label>
                            <input type="text" name="name" id="name" required
                                   value="{{ old('name', $league->name) }}"
                                   placeholder="Ej: Liga Española, Premier League, Serie A..."
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Country -->
                        <div class="mb-6">
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                                País
                            </label>
                            <input type="text" name="country" id="country"
                                   value="{{ old('country', $league->country) }}"
                                   placeholder="Ej: España, Inglaterra, Italia..."
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('country')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      placeholder="Descripción opcional de la liga..."
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $league->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Stats -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                            <h3 class="font-semibold text-gray-800 mb-2">📊 Estado Actual</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Equipos asociados:</span>
                                    <span class="font-medium">{{ $league->teams()->count() }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Creada:</span>
                                    <span class="font-medium">{{ $league->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Warning if has teams -->
                        @if($league->teams()->count() > 0)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                <h3 class="font-semibold text-yellow-800 mb-2">⚠️ Advertencia</h3>
                                <p class="text-sm text-yellow-700">
                                    Esta liga tiene {{ $league->teams()->count() }} equipos asociados.
                                    Al cambiar el nombre, también se actualizará en todos los partidos y estadísticas relacionadas.
                                </p>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex justify-between">
                            <a href="{{ route('leagues.index') }}"
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Liga
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-blue-800 mb-3">🔗 Acciones Rápidas</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('leagues.show', $league) }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                        Ver Detalles
                    </a>
                    <a href="{{ route('teams.create', ['league' => $league->id]) }}"
                       class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                        Agregar Equipo
                    </a>
                    @if($league->teams()->count() >= 2)
                        <a href="{{ route('matches.create.index', ['league' => $league->id]) }}"
                           class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm">
                            Crear Partido
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>