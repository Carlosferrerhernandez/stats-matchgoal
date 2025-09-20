<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\Team;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function create()
    {
        return view('leagues.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        League::create($validated);

        return redirect()->route('leagues.index')->with('success', 'Liga registrada correctamente.');
    }

    public function index()
    {
        $leagues = League::withCount('teams')->get();
        return view('leagues.index', compact('leagues'));
    }

    public function show(League $league)
    {
        $league->load('teams');
        return view('leagues.show', compact('league'));
    }

    public function edit(League $league)
    {
        return view('leagues.edit', compact('league'));
    }

    public function update(Request $request, League $league)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        $league->update($validated);

        return redirect()->route('leagues.index')->with('success', 'Liga actualizada correctamente.');
    }

    public function destroy(League $league)
    {
        if ($league->teams()->count() > 0) {
            return redirect()->route('leagues.index')->with('error', 'No se puede eliminar una liga que tiene equipos asociados.');
        }

        $league->delete();

        return redirect()->route('leagues.index')->with('success', 'Liga eliminada correctamente.');
    }
}

