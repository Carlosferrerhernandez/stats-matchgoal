<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'market_id',
        'rule_name',
        'condition_type',
        'operator',
        'value',
        'weight',
        'is_active',
        'description'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    // Evalúa si la regla se cumple para un equipo específico
    public function evaluate($teamStat, $opponentStat = null)
    {
        $value = $this->getValueFromTeamStat($teamStat);

        if ($value === null) {
            return false;
        }

        return $this->compareValues($value, $this->value, $this->operator);
    }

    private function getValueFromTeamStat($teamStat)
    {
        switch ($this->condition_type) {
            case 'win_percent_difference':
                return $teamStat->getWinPercentage();
            case 'streak_first_to_score':
                return $teamStat->getStreakEffectiveness('first_to_score');
            case 'streak_first_half_winner':
                return $teamStat->getStreakEffectiveness('first_half_winner');
            case 'streak_both_teams_score':
                return $teamStat->getStreakEffectiveness('both_teams_score');
            case 'home_win_percentage':
                return $teamStat->getHomeWinPercentage();
            case 'away_win_percentage':
                return $teamStat->getAwayWinPercentage();
            default:
                return null;
        }
    }

    private function compareValues($actual, $expected, $operator)
    {
        switch ($operator) {
            case '>=':
                return $actual >= $expected;
            case '<=':
                return $actual <= $expected;
            case '>':
                return $actual > $expected;
            case '<':
                return $actual < $expected;
            case '=':
                return abs($actual - $expected) < 0.01; // Para decimales
            default:
                return false;
        }
    }
}
