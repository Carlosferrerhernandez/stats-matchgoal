<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\Channel;
use App\Models\League;
use App\Models\Team;
use App\Models\Prediction;
use Illuminate\Http\Request;

class BetController extends Controller
{
    public function create()
    {
        $leagues = League::all();
        $teams = Team::all();
        $channels = Channel::all();

        return view('app.bets.create', compact('leagues', 'teams', 'channels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'league_id' => 'required|exists:leagues,id',
            'team_id' => 'required|exists:teams,id',
            'achievement' => 'required|string|max:255',
            'channel_id' => 'required|exists:channels,id',
            'stake' => 'required|integer|min:1|max:10',
            'odds' => 'required|numeric|min:1',
            'result' => 'required|boolean',
        ]);

        $user = auth()->user();
        $amount = ($validated['stake'] / 100) * $user->bank;

        $bet = Bet::create([
            'user_id' => $user->id,
            'league_id' => $validated['league_id'],
            'team_id' => $validated['team_id'],
            'achievement' => $validated['achievement'],
            'channel_id' => $validated['channel_id'],
            'amount' => $amount,
            'odds' => $validated['odds'],
            'result' => $validated['result'],
            'stake' => $validated['stake'],
        ]);

        if ($validated['result']) {
            $profit = $bet->calculateProfit();
            $user->bank += $profit;
        } else {
            $user->bank -= $amount;
        }

        $user->save();

        return redirect()->route('predictions')->with('success', 'Apuesta registrada.');
    }

    public function showPredictions()
    {
        $predictions = auth()->user()->predictions()
            ->with(['match.homeTeam', 'match.awayTeam', 'market'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('predictions.index', compact('predictions'));
    }
}

