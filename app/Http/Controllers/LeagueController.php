<?php

namespace App\Http\Controllers;

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
        $leagues = League::all();
        return view('leagues.index', compact('leagues'));
    }
}

