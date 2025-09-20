<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_id',
        'home_team_id',
        'away_team_id',
        'match_date',
        'status',
        'home_win_percent',
        'draw_percent',
        'away_win_percent',
        'home_goals',
        'away_goals',
        'home_goals_first_half',
        'away_goals_first_half',
        'external_id',
        'last_updated'
    ];

    protected $casts = [
        'match_date' => 'datetime',
        'home_win_percent' => 'decimal:2',
        'draw_percent' => 'decimal:2',
        'away_win_percent' => 'decimal:2',
        'last_updated' => 'datetime',
    ];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class, 'match_id');
    }

    // Helper methods
    public function getFavorite()
    {
        if ($this->home_win_percent > $this->away_win_percent) {
            return $this->homeTeam;
        }
        return $this->awayTeam;
    }

    public function isFinished()
    {
        return $this->status === 'finished';
    }

    public function getTotalGoals()
    {
        return ($this->home_goals ?? 0) + ($this->away_goals ?? 0);
    }
}
