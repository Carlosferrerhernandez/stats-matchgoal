<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\League;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('league')->get();
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        $leagues = League::all();
        return view('teams.create', compact('leagues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'league_id' => 'required|exists:leagues,id',
            'city' => 'nullable|string|max:100',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'description' => 'nullable|string|max:500',
        ]);

        Team::create($validated);

        return redirect()->route('teams.index')->with('success', 'Equipo registrado correctamente.');
    }

    public function show(Team $team)
    {
        $team->load(['league', 'stats']);
        return view('teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $leagues = League::all();
        return view('teams.edit', compact('team', 'leagues'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'league_id' => 'required|exists:leagues,id',
            'city' => 'nullable|string|max:100',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'description' => 'nullable|string|max:500',
        ]);

        $team->update($validated);

        return redirect()->route('teams.index')->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(Team $team)
    {
        if ($team->homeMatches()->count() > 0 || $team->awayMatches()->count() > 0) {
            return redirect()->route('teams.index')->with('error', 'No se puede eliminar un equipo que tiene partidos asociados.');
        }

        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Equipo eliminado correctamente.');
    }
}

