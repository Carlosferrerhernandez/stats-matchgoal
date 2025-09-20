<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'league_id',
        'season',
        'matches_played',
        'wins',
        'draws',
        'losses',
        'goals_for',
        'goals_against',

        // Rachas básicas
        'current_win_streak',
        'current_draw_streak',
        'current_loss_streak',
        'current_unbeaten_streak',
        'current_winless_streak',

        // Rachas específicas (success/total)
        'streak_no_defeats_success',
        'streak_no_defeats_total',
        'streak_victories_success',
        'streak_victories_total',
        'streak_over_25_goals_success',
        'streak_over_25_goals_total',
        'streak_under_25_goals_success',
        'streak_under_25_goals_total',
        'streak_under_45_cards_success',
        'streak_under_45_cards_total',
        'streak_under_105_corners_success',
        'streak_under_105_corners_total',
        'streak_no_wins_success',
        'streak_no_wins_total',
        'streak_no_clean_sheets_success',
        'streak_no_clean_sheets_total',
        'streak_first_to_concede_success',
        'streak_first_to_concede_total',
        'streak_first_to_score_success',
        'streak_first_to_score_total',
        'streak_first_half_winner_success',
        'streak_first_half_winner_total',
        'streak_first_half_loser_success',
        'streak_first_half_loser_total',
        'streak_both_teams_score_success',
        'streak_both_teams_score_total',

        // Local vs Visitante
        'home_wins',
        'home_draws',
        'home_losses',
        'away_wins',
        'away_draws',
        'away_losses',
        'last_updated'
    ];

    protected $casts = [
        'last_updated' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    // Métodos helper para calcular porcentajes de efectividad
    public function getStreakEffectiveness(string $streakType)
    {
        $successField = "streak_{$streakType}_success";
        $totalField = "streak_{$streakType}_total";

        if ($this->$totalField == 0) {
            return 0;
        }

        return ($this->$successField / $this->$totalField) * 100;
    }

    public function getWinPercentage()
    {
        if ($this->matches_played == 0) {
            return 0;
        }
        return ($this->wins / $this->matches_played) * 100;
    }

    public function getHomeWinPercentage()
    {
        $homeMatches = $this->home_wins + $this->home_draws + $this->home_losses;
        if ($homeMatches == 0) {
            return 0;
        }
        return ($this->home_wins / $homeMatches) * 100;
    }

    public function getAwayWinPercentage()
    {
        $awayMatches = $this->away_wins + $this->away_draws + $this->away_losses;
        if ($awayMatches == 0) {
            return 0;
        }
        return ($this->away_wins / $awayMatches) * 100;
    }
}
