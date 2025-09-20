@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Equipos Registrados</h2>

        <div class="table-responsive">
            <table id="teams-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nombre del Equipo</th>
                        <th>Liga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teams as $team)
                        <tr>
                            <td>{{ $team->name }}</td>
                            <td>{{ $team->league->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
