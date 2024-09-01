<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\League;
use App\Models\Team;

class TeamController extends Controller
{
    public function create()
    {
        $leagues = League::all();
        return view('app.teams.create', compact('leagues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'league_id' => 'required|exists:leagues,id',
        ]);

        Team::create($validated);

        return redirect()->route('app.teams.index')->with('success', 'Equipo registrado correctamente.');
    }

    public function index()
    {
        $teams = Team::with('league')->get();
        return view('app.teams.index', compact('teams'));
    }
}

