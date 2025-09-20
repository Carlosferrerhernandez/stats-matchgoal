<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $fillable = [
        'user_id',
        'league_id',
        'team_id',
        'channel_id',
        'achievement',
        'amount',
        'odds',
        'stake',
        'result'
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    protected $casts = [
        'amount' => 'decimal:2',
        'odds' => 'decimal:2',
        'result' => 'boolean',
    ];

    public function calculateProfit()
    {
        if ($this->result) {
            return $this->amount * $this->odds - $this->amount; // Ganancia neta
        }
        return -$this->amount; // Pérdida
    }
}

