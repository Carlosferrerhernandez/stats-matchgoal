<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MarketAnalysisService;
use App\Models\FootballMatch;
use App\Models\User;

class AnalyzeMatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:analyze {match_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze a football match and generate predictions using the market algorithm';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $matchId = $this->argument('match_id');

        if ($matchId) {
            $match = FootballMatch::find($matchId);
            if (!$match) {
                $this->error("Match with ID {$matchId} not found.");
                return 1;
            }
        } else {
            // Analizar el partido Betis vs Real Sociedad por defecto
            $match = FootballMatch::where('external_id', 'BETIS_RSOC_20240921')->first();
            if (!$match) {
                $this->error("Default match (Betis vs Real Sociedad) not found.");
                return 1;
            }
        }

        $user = User::where('email', 'carlos@matchgoal.com')->first();
        if (!$user) {
            $this->error("User not found.");
            return 1;
        }

        $this->info("🔍 Analyzing Match: {$match->homeTeam->name} vs {$match->awayTeam->name}");
        $this->info("📊 Home Win: {$match->home_win_percent}% | Draw: {$match->draw_percent}% | Away Win: {$match->away_win_percent}%");
        $this->line("");

        $analysisService = new MarketAnalysisService();
        $prediction = $analysisService->analyzeMatch($match, $user);

        if ($prediction) {
            $this->info("✅ PREDICCIÓN GENERADA");
            $this->line("🎯 Mercado: {$prediction->market->name}");
            $this->line("📝 Pronóstico: {$prediction->prediction}");
            $this->line("🔥 Confianza: {$prediction->confidence_score}%");
            $maxStake = $prediction->user->settings->max_stake_level ?? 4;
            $betAmount = $prediction->calculateBetAmountCOP();
            $this->line("💰 Stake Sugerido: {$prediction->suggested_stake}/{$maxStake}");
            $this->line("💵 Monto: " . number_format($betAmount, 0, ',', '.') . " COP");
            $this->line("📋 Razonamiento: {$prediction->reasoning}");
            $this->line("");
            $this->info("💾 Predicción guardada con ID: {$prediction->id}");
        } else {
            $this->warn("❌ No se pudo generar una predicción para este partido.");
            $this->line("Posibles razones:");
            $this->line("- No hay suficientes datos estadísticos");
            $this->line("- Ningún mercado cumple los criterios mínimos");
            $this->line("- La confianza está por debajo del umbral");
        }

        return 0;
    }
}
