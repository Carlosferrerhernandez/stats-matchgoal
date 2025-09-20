<?php

namespace App\Services;

use App\Models\FootballMatch;
use App\Models\Market;
use App\Models\TeamStat;
use App\Models\Prediction;
use App\Models\User;

class MarketAnalysisService
{
    public function analyzeMatch(FootballMatch $match, User $user)
    {
        // 1. Determinar el favorito
        $favorite = $this->getFavorite($match);
        $underdog = $this->getUnderdog($match);

        // 2. Obtener estad�sticas de ambos equipos
        $favoriteStats = $this->getTeamStats($favorite);
        $underdogStats = $this->getTeamStats($underdog);

        if (!$favoriteStats || !$underdogStats) {
            return null; // No hay suficientes datos
        }

        // 3. Analizar cada mercado
        $markets = Market::where('is_active', true)->get();
        $marketAnalysis = [];

        foreach ($markets as $market) {
            $analysis = $this->analyzeMarket($market, $match, $favoriteStats, $underdogStats);
            if ($analysis) {
                $marketAnalysis[$market->key] = $analysis;
            }
        }

        // 4. Seleccionar el mejor mercado
        $bestMarket = $this->selectBestMarket($marketAnalysis);

        if (!$bestMarket) {
            return null;
        }

        // 5. Crear predicci�n
        return $this->createPrediction($match, $bestMarket, $user);
    }

    private function getFavorite(FootballMatch $match)
    {
        return $match->home_win_percent > $match->away_win_percent
            ? $match->homeTeam
            : $match->awayTeam;
    }

    private function getUnderdog(FootballMatch $match)
    {
        return $match->home_win_percent > $match->away_win_percent
            ? $match->awayTeam
            : $match->homeTeam;
    }

    private function getTeamStats($team)
    {
        return TeamStat::where('team_id', $team->id)
                      ->where('season', '2024-25')
                      ->first();
    }

    private function analyzeMarket(Market $market, FootballMatch $match, TeamStat $favoriteStats, TeamStat $underdogStats)
    {
        switch ($market->key) {
            case Market::FIRST_GOAL:
                return $this->analyzeFirstGoal($match, $favoriteStats, $underdogStats);

            case Market::FIRST_HALF_WINNER:
                return $this->analyzeFirstHalfWinner($match, $favoriteStats, $underdogStats);

            case Market::MATCH_WINNER:
                return $this->analyzeMatchWinner($match, $favoriteStats, $underdogStats);

            case Market::BOTH_TEAMS_SCORE:
                return $this->analyzeBothTeamsScore($match, $favoriteStats, $underdogStats);

            default:
                return null;
        }
    }

    private function analyzeFirstGoal(FootballMatch $match, TeamStat $favoriteStats, TeamStat $underdogStats)
    {
        // Tu metodolog�a: Evaluar rachas de "Primero en marcar" vs "Primero en encajar"
        $favoriteFirstGoal = $favoriteStats->getStreakEffectiveness('first_to_score');
        $underdogFirstConcede = $underdogStats->getStreakEffectiveness('first_to_concede');

        // Bonus por ser favorito + local�a
        $homeBonus = $this->getFavorite($match)->id === $match->home_team_id ? 10 : 0;
        $favoriteBonus = $this->getFavoriteStrengthBonus($match);

        $confidence = $favoriteFirstGoal + ($underdogFirstConcede * 0.7) + $homeBonus + $favoriteBonus;

        // Minimum requirements: Favorable >= 80% AND Underdog_concede >= 60%
        if ($favoriteFirstGoal >= 80 && $underdogFirstConcede >= 60) {
            return [
                'market_key' => Market::FIRST_GOAL,
                'prediction' => $this->getFavorite($match)->name . ' - Primero en Marcar',
                'confidence' => min(100, $confidence),
                'reasoning' => "Favorito con {$favoriteFirstGoal}% efectividad marcando primero. Rival encaja primero en {$underdogFirstConcede}% de casos.",
                'favorite_stat' => $favoriteFirstGoal,
                'underdog_stat' => $underdogFirstConcede
            ];
        }

        return null;
    }

    private function analyzeFirstHalfWinner(FootballMatch $match, TeamStat $favoriteStats, TeamStat $underdogStats)
    {
        $favoriteFirstHalf = $favoriteStats->getStreakEffectiveness('first_half_winner');
        $underdogFirstHalf = $underdogStats->getStreakEffectiveness('first_half_loser');

        $homeBonus = $this->getFavorite($match)->id === $match->home_team_id ? 15 : 0; // Mayor bonus para primeros tiempos en casa
        $favoriteBonus = $this->getFavoriteStrengthBonus($match);

        $confidence = $favoriteFirstHalf + ($underdogFirstHalf * 0.6) + $homeBonus + $favoriteBonus;

        // Requirements: Favorable >= 75% AND (Home game OR very strong favorite)
        $isHome = $this->getFavorite($match)->id === $match->home_team_id;
        $isStrongFavorite = $this->getFavoriteAdvantage($match) >= 20; // 20+ puntos de diferencia

        if ($favoriteFirstHalf >= 75 && ($isHome || $isStrongFavorite)) {
            return [
                'market_key' => Market::FIRST_HALF_WINNER,
                'prediction' => $this->getFavorite($match)->name . ' - Ganador Primer Periodo',
                'confidence' => min(100, $confidence),
                'reasoning' => "Favorito gana {$favoriteFirstHalf}% de primeros tiempos. " . ($isHome ? "Juega en casa." : "Muy superior al rival."),
                'favorite_stat' => $favoriteFirstHalf,
                'underdog_stat' => $underdogFirstHalf
            ];
        }

        return null;
    }

    private function analyzeMatchWinner(FootballMatch $match, TeamStat $favoriteStats, TeamStat $underdogStats)
    {
        $favoriteWinRate = $favoriteStats->getWinPercentage();
        $underdogWinRate = $underdogStats->getWinPercentage();
        $favoriteNoDefeats = $favoriteStats->getStreakEffectiveness('no_defeats');

        $homeBonus = $this->getFavorite($match)->id === $match->home_team_id ? 8 : 0;
        $favoriteBonus = $this->getFavoriteStrengthBonus($match);

        $confidence = $favoriteWinRate + ($favoriteNoDefeats * 0.3) + $homeBonus + $favoriteBonus - ($underdogWinRate * 0.2);

        // Conservative approach: Only very clear favorites
        $winRateDiff = $favoriteWinRate - $underdogWinRate;
        $favoriteAdvantage = $this->getFavoriteAdvantage($match);

        if ($favoriteWinRate >= 70 && $winRateDiff >= 25 && $favoriteAdvantage >= 15) {
            return [
                'market_key' => Market::MATCH_WINNER,
                'prediction' => $this->getFavorite($match)->name . ' - Ganador del Partido',
                'confidence' => min(100, $confidence),
                'reasoning' => "Favorito claro: {$favoriteWinRate}% wins vs {$underdogWinRate}%. Diferencia de {$favoriteAdvantage}% en pron�sticos.",
                'favorite_stat' => $favoriteWinRate,
                'underdog_stat' => $underdogWinRate
            ];
        }

        return null;
    }

    private function analyzeBothTeamsScore(FootballMatch $match, TeamStat $favoriteStats, TeamStat $underdogStats)
    {
        $favoriteBTTS = $favoriteStats->getStreakEffectiveness('both_teams_score');
        $underdogBTTS = $underdogStats->getStreakEffectiveness('both_teams_score');
        $favoriteNoCleanSheets = $favoriteStats->getStreakEffectiveness('no_clean_sheets');

        // Average BTTS effectiveness
        $avgBTTS = ($favoriteBTTS + $underdogBTTS) / 2;
        $confidence = $avgBTTS + ($favoriteNoCleanSheets * 0.4);

        // Requirements: Both teams have good BTTS record
        if ($favoriteBTTS >= 75 && $underdogBTTS >= 60 && $avgBTTS >= 70) {
            return [
                'market_key' => Market::BOTH_TEAMS_SCORE,
                'prediction' => 'Ambos Equipos Marcan - S�',
                'confidence' => min(100, $confidence),
                'reasoning' => "Favorito: {$favoriteBTTS}% BTTS. Rival: {$underdogBTTS}% BTTS. Promedio: {$avgBTTS}%.",
                'favorite_stat' => $favoriteBTTS,
                'underdog_stat' => $underdogBTTS
            ];
        }

        return null;
    }

    private function getFavoriteStrengthBonus(FootballMatch $match)
    {
        $advantage = $this->getFavoriteAdvantage($match);

        if ($advantage >= 30) return 15; // Muy superior
        if ($advantage >= 20) return 10; // Superior
        if ($advantage >= 15) return 5;  // Ligero favorito

        return 0;
    }

    private function getFavoriteAdvantage(FootballMatch $match)
    {
        $favorite = $this->getFavorite($match);
        $favoritePercent = $favorite->id === $match->home_team_id
            ? $match->home_win_percent
            : $match->away_win_percent;

        $underdogPercent = $favorite->id === $match->home_team_id
            ? $match->away_win_percent
            : $match->home_win_percent;

        return $favoritePercent - $underdogPercent;
    }

    private function selectBestMarket(array $marketAnalysis)
    {
        if (empty($marketAnalysis)) {
            return null;
        }

        // Ordenar por confianza (descendente)
        uasort($marketAnalysis, function($a, $b) {
            return $b['confidence'] <=> $a['confidence'];
        });

        return reset($marketAnalysis); // Retorna el de mayor confianza
    }

    private function createPrediction(FootballMatch $match, array $analysis, User $user)
    {
        $market = Market::where('key', $analysis['market_key'])->first();
        $userSettings = $user->settings;

        // Calcular stake basado en confianza
        $stake = $userSettings ? $userSettings->calculateStake($analysis['confidence']) : $this->getDefaultStake($analysis['confidence']);

        // Solo crear predicci�n si supera el umbral de confianza
        $minConfidence = $userSettings ? $userSettings->min_confidence_threshold : 60;
        if ($analysis['confidence'] < $minConfidence) {
            return null;
        }

        return Prediction::create([
            'match_id' => $match->id,
            'market_id' => $market->id,
            'user_id' => $user->id,
            'prediction' => $analysis['prediction'],
            'confidence_score' => $analysis['confidence'],
            'suggested_stake' => $stake,
            'reasoning' => $analysis['reasoning'],
            'status' => Prediction::STATUS_PENDING
        ]);
    }

    private function getDefaultStake($confidence)
    {
        // Stakes 1-4 basado en confianza
        if ($confidence >= 90) return 4;  // Máxima confianza = 4% bankroll
        if ($confidence >= 80) return 3;  // Alta confianza = 3% bankroll
        if ($confidence >= 70) return 2;  // Buena confianza = 2% bankroll
        if ($confidence >= 60) return 1;  // Confianza mínima = 1% bankroll
        return 0; // No apostar si confianza < 60%
    }
}