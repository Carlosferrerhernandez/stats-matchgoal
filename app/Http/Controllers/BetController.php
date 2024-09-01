<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class BetController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'channel_id' => 'required|exists:channels,id',
            'stake' => 'required|integer|min:1|max:10',
            'odds' => 'required|numeric|min:1',
            'result' => 'required|boolean',
        ]);

        $user = auth()->user();
        $amount = ($validated['stake'] / 100) * $user->bank;

        // Registrar la apuesta
        $bet = Bet::create([
            'user_id' => $user->id,
            'channel_id' => $validated['channel_id'],
            'amount' => $amount,
            'odds' => $validated['odds'],
            'result' => $validated['result'],
            'stake' => $validated['stake'],
        ]);

        // Actualizar el bank del usuario
        if ($validated['result']) {
            $profit = $bet->calculateProfit();
            $user->bank += $profit;
        } else {
            $user->bank -= $amount;
        }

        $user->save();

        return redirect()->back()->with('success', 'Apuesta registrada.');
    }

    public function showPredictions()
    {
        // Obtener pronósticos del canal gratuito y premium
        $freeChannel = Channel::where('name', 'Gratuito')->first();
        $premiumChannel = Channel::where('name', 'Premium')->first();

        $freeBets = $freeChannel ? $freeChannel->bets()->get() : collect([]);
        $premiumBets = $premiumChannel ? $premiumChannel->bets()->get() : collect([]);

        return view('predictions', compact('freeBets', 'premiumBets'));
    }
}

