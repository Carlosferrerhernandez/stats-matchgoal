<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Liga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            🏆 Crear Nueva Liga
                        </h1>
                        <p class="text-gray-600 mt-2">Registra una nueva competición en el sistema</p>
                    </div>

                    <form method="POST" action="{{ route('leagues.store') }}">
                        @csrf

                        <!-- League Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre de la Liga *
                            </label>
                            <input type="text" name="name" id="name" required
                                   value="{{ old('name') }}"
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
                                   value="{{ old('country') }}"
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
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Information Panel -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <h3 class="font-semibold text-blue-800 mb-2">📋 Información</h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• El nombre de la liga debe ser único en el sistema</li>
                                <li>• Podrás agregar equipos después de crear la liga</li>
                                <li>• La descripción y país son opcionales pero recomendados</li>
                                <li>• Una vez creada, podrás editar todos los campos</li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between">
                            <a href="{{ route('leagues.index') }}"
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Crear Liga
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-semibold text-green-800 mb-2">✅ Próximos Pasos</h3>
                <p class="text-sm text-green-700">
                    Después de crear la liga, podrás:
                </p>
                <ul class="text-sm text-green-700 mt-2 space-y-1">
                    <li>• Agregar equipos a la liga</li>
                    <li>• Crear partidos entre los equipos</li>
                    <li>• Generar predicciones automáticas</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>