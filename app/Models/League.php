<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $fillable = [
        'name',
        'country',
        'description',
        'season'
    ];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function matches()
    {
        return $this->hasMany(FootballMatch::class);
    }

    public function bets()
    {
        return $this->hasMany(Bet::class);
    }

    public function teamStats()
    {
        return $this->hasMany(TeamStat::class);
    }
}
