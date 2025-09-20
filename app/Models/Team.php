<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'league_id', 'city', 'founded_year', 'description'];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function homeMatches()
    {
        return $this->hasMany(FootballMatch::class, 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(FootballMatch::class, 'away_team_id');
    }

    public function allMatches()
    {
        return FootballMatch::where('home_team_id', $this->id)
                           ->orWhere('away_team_id', $this->id);
    }

    public function bets()
    {
        return $this->hasMany(Bet::class);
    }

    public function stats()
    {
        return $this->hasMany(TeamStat::class);
    }

    public function currentSeasonStats()
    {
        return $this->hasOne(TeamStat::class)
                   ->where('season', '2024-25')
                   ->where('league_id', $this->league_id);
    }
}

