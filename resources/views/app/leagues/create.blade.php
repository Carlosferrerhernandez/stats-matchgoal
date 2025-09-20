@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Registrar Liga</h2>

        <form action="{{ route('leagues.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Liga</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full" required>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Registrar Liga</button>
        </form>
    </div>
@endsection
