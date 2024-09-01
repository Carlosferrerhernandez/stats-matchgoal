@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-4">Pronósticos del Canal Gratuito</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($freeBets as $bet)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold">Liga: {{ $bet->league }}</h3>
                    <p>Equipo: {{ $bet->team }}</p>
                    <p>Logro: {{ $bet->achievement }}</p>
                    <p>Cuota: {{ $bet->odds }}</p>
                    <p>Apuesta: {{ $bet->amount }} COP</p>
                    <p>Resultado: 
                        @if ($bet->result)
                            <span class="text-green-500">Ganó</span>
                        @else
                            <span class="text-red-500">Perdió</span>
                        @endif
                    </p>
                </div>
            @empty
                <p>No hay pronósticos en el canal gratuito.</p>
            @endforelse
        </div>

        <h2 class="text-2xl font-bold mt-8 mb-4">Pronósticos del Canal Premium</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($premiumBets as $bet)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold">Liga: {{ $bet->league }}</h3>
                    <p>Equipo: {{ $bet->team }}</p>
                    <p>Logro: {{ $bet->achievement }}</p>
                    <p>Cuota: {{ $bet->odds }}</p>
                    <p>Apuesta: {{ $bet->amount }} COP</p>
                    <p>Resultado: 
                        @if ($bet->result)
                            <span class="text-green-500">Ganó</span>
                        @else
                            <span class="text-red-500">Perdió</span>
                        @endif
                    </p>
                </div>
            @empty
                <p>No hay pronósticos en el canal premium.</p>
            @endforelse
        </div>
    </div>
@endsection
