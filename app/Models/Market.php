<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function rules()
    {
        return $this->hasMany(MarketRule::class);
    }

    public function activeRules()
    {
        return $this->hasMany(MarketRule::class)->where('is_active', true);
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }

    // Constantes para los mercados
    const FIRST_HALF_WINNER = 'first_half_winner';
    const MATCH_WINNER = 'match_winner';
    const FIRST_GOAL = 'first_goal';
    const BOTH_TEAMS_SCORE = 'both_teams_score';

    public static function getMarketKeys()
    {
        return [
            self::FIRST_HALF_WINNER,
            self::MATCH_WINNER,
            self::FIRST_GOAL,
            self::BOTH_TEAMS_SCORE,
        ];
    }
}
