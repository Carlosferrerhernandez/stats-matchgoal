<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\League;
use App\Models\Team;
use App\Models\FootballMatch;
use App\Models\TeamStat;
use App\Models\Market;
use App\Services\MarketAnalysisService;

class MatchCreatorController extends Controller
{
    public function index()
    {
        return view('matches.create.index');
    }

    // Paso 1: Seleccionar liga y equipos
    public function step1()
    {
        $leagues = League::all();
        return view('matches.create.step1', compact('leagues'));
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'league_id' => 'required|exists:leagues,id',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'match_date' => 'required|date|after:now'
        ]);

        // Guardar en sesión para el flujo multi-paso
        session(['match_data' => $validated]);

        return redirect()->route('matches.create.step2');
    }

    // Paso 2: Porcentajes de victoria
    public function step2()
    {
        $matchData = session('match_data');
        if (!$matchData) {
            return redirect()->route('matches.create.step1')->with('error', 'Debe completar el paso 1 primero.');
        }

        $homeTeam = Team::find($matchData['home_team_id']);
        $awayTeam = Team::find($matchData['away_team_id']);

        return view('matches.create.step2', compact('homeTeam', 'awayTeam'));
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'home_win_percent' => 'required|numeric|min:0|max:100',
            'draw_percent' => 'required|numeric|min:0|max:100',
            'away_win_percent' => 'required|numeric|min:0|max:100'
        ]);

        // Validar que sumen 100%
        $total = $validated['home_win_percent'] + $validated['draw_percent'] + $validated['away_win_percent'];
        if (abs($total - 100) > 0.1) {
            return back()->withErrors(['total' => 'Los porcentajes deben sumar 100%'])->withInput();
        }

        // Agregar a los datos de la sesión
        $matchData = session('match_data');
        $matchData = array_merge($matchData, $validated);
        session(['match_data' => $matchData]);

        return redirect()->route('matches.create.step3');
    }

    // Paso 3: Rachas del equipo local
    public function step3()
    {
        $matchData = session('match_data');
        if (!$matchData) {
            return redirect()->route('matches.create.step1');
        }

        $homeTeam = Team::find($matchData['home_team_id']);
        return view('matches.create.step3', compact('homeTeam'));
    }

    public function storeStep3(Request $request)
    {
        $validated = $request->validate([
            // Rachas simples (número consecutivo)
            'home_wins_streak' => 'nullable|integer|min:0',
            'home_defeats_streak' => 'nullable|integer|min:0',
            'home_no_defeats_streak' => 'nullable|integer|min:0',
            'home_no_clean_sheet_streak' => 'nullable|integer|min:0',

            // Rachas con formato (aciertos/total)
            'home_first_to_score_success' => 'nullable|integer|min:0',
            'home_first_to_score_total' => 'nullable|integer|min:0',
            'home_first_half_winner_success' => 'nullable|integer|min:0',
            'home_first_half_winner_total' => 'nullable|integer|min:0',
            'home_both_teams_score_success' => 'nullable|integer|min:0',
            'home_both_teams_score_total' => 'nullable|integer|min:0',
            'home_over_25_success' => 'nullable|integer|min:0',
            'home_over_25_total' => 'nullable|integer|min:0',
            'home_under_25_success' => 'nullable|integer|min:0',
            'home_under_25_total' => 'nullable|integer|min:0',
        ]);

        $matchData = session('match_data');
        $matchData['home_stats'] = $validated;
        session(['match_data' => $matchData]);

        return redirect()->route('matches.create.step4');
    }

    // Paso 4: Rachas del equipo visitante
    public function step4()
    {
        $matchData = session('match_data');
        if (!$matchData) {
            return redirect()->route('matches.create.step1');
        }

        $awayTeam = Team::find($matchData['away_team_id']);
        return view('matches.create.step4', compact('awayTeam'));
    }

    public function storeStep4(Request $request)
    {
        $validated = $request->validate([
            // Rachas simples (número consecutivo)
            'away_wins_streak' => 'nullable|integer|min:0',
            'away_defeats_streak' => 'nullable|integer|min:0',
            'away_no_defeats_streak' => 'nullable|integer|min:0',
            'away_no_clean_sheet_streak' => 'nullable|integer|min:0',

            // Rachas con formato (aciertos/total)
            'away_first_to_score_success' => 'nullable|integer|min:0',
            'away_first_to_score_total' => 'nullable|integer|min:0',
            'away_first_half_winner_success' => 'nullable|integer|min:0',
            'away_first_half_winner_total' => 'nullable|integer|min:0',
            'away_both_teams_score_success' => 'nullable|integer|min:0',
            'away_both_teams_score_total' => 'nullable|integer|min:0',
            'away_over_25_success' => 'nullable|integer|min:0',
            'away_over_25_total' => 'nullable|integer|min:0',
            'away_under_25_success' => 'nullable|integer|min:0',
            'away_under_25_total' => 'nullable|integer|min:0',
        ]);

        $matchData = session('match_data');
        $matchData['away_stats'] = $validated;
        session(['match_data' => $matchData]);

        return redirect()->route('matches.create.step5');
    }

    // Paso 5: Cuotas de mercados
    public function step5()
    {
        $matchData = session('match_data');
        if (!$matchData) {
            return redirect()->route('matches.create.step1');
        }

        $markets = Market::where('is_active', true)->get();
        $homeTeam = Team::find($matchData['home_team_id']);
        $awayTeam = Team::find($matchData['away_team_id']);

        return view('matches.create.step5', compact('markets', 'homeTeam', 'awayTeam'));
    }

    public function storeStep5(Request $request)
    {
        $markets = Market::where('is_active', true)->get();
        $rules = [];

        foreach ($markets as $market) {
            $rules[$market->key . '_odds'] = 'nullable|numeric|min:1.01|max:50';
        }

        $validated = $request->validate($rules);

        $matchData = session('match_data');
        $matchData['market_odds'] = $validated;
        session(['match_data' => $matchData]);

        return redirect()->route('matches.create.analyze');
    }

    // Paso 6: Analizar y mostrar predicción
    public function analyze()
    {
        $matchData = session('match_data');
        if (!$matchData) {
            return redirect()->route('matches.create.step1');
        }

        try {
            // Crear el partido temporalmente
            $match = $this->createMatchFromSessionData($matchData);

            // Ejecutar el algoritmo
            $analysisService = new MarketAnalysisService();
            $prediction = $analysisService->analyzeMatch($match, auth()->user());

            $homeTeam = Team::find($matchData['home_team_id']);
            $awayTeam = Team::find($matchData['away_team_id']);

            return view('matches.create.analyze', compact('match', 'prediction', 'homeTeam', 'awayTeam', 'matchData'));

        } catch (\Exception $e) {
            return back()->with('error', 'Error al analizar el partido: ' . $e->getMessage());
        }
    }

    public function confirm(Request $request)
    {
        $matchData = session('match_data');
        if (!$matchData) {
            return redirect()->route('matches.create.step1');
        }

        try {
            // Crear el partido definitivo y las estadísticas
            $match = $this->createMatchFromSessionData($matchData, true);

            // Verificar si hay predicción disponible
            $analysisService = new MarketAnalysisService();
            $prediction = null;

            try {
                $prediction = $analysisService->analyzeMatch($match, auth()->user());
            } catch (\Exception $e) {
                // Si no se puede generar predicción, continuar guardando el partido
            }

            // Limpiar sesión
            session()->forget('match_data');

            // Mensaje personalizado según si hay predicción o no
            if ($prediction && !empty($prediction['recommendations'])) {
                return redirect()->route('predictions')->with('success', 'Partido creado y analizado exitosamente. ¡Predicción generada!');
            } else {
                return redirect()->route('predictions')->with('success', 'Partido creado exitosamente. El partido ha sido guardado para análisis futuro.');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    private function createMatchFromSessionData($data, $permanent = false)
    {
        // Crear o actualizar estadísticas de equipos
        $this->updateTeamStats($data['home_team_id'], $data['league_id'], $data['home_stats'] ?? []);
        $this->updateTeamStats($data['away_team_id'], $data['league_id'], $data['away_stats'] ?? []);

        // Crear partido
        $matchData = [
            'league_id' => $data['league_id'],
            'home_team_id' => $data['home_team_id'],
            'away_team_id' => $data['away_team_id'],
            'match_date' => $data['match_date'],
            'status' => 'scheduled',
            'home_win_percent' => $data['home_win_percent'],
            'draw_percent' => $data['draw_percent'],
            'away_win_percent' => $data['away_win_percent'],
            'external_id' => 'MANUAL_' . time() . '_' . $data['home_team_id'] . '_' . $data['away_team_id']
        ];

        if ($permanent) {
            return FootballMatch::create($matchData);
        } else {
            // Para análisis temporal, crear una instancia sin guardar
            return new FootballMatch($matchData);
        }
    }

    private function updateTeamStats($teamId, $leagueId, $stats)
    {
        if (empty($stats)) return;

        TeamStat::updateOrCreate(
            [
                'team_id' => $teamId,
                'league_id' => $leagueId,
                'season' => '2024-25'
            ],
            [
                'streak_first_to_score_success' => $stats['first_to_score_success'] ?? $stats['home_first_to_score_success'] ?? $stats['away_first_to_score_success'] ?? 0,
                'streak_first_to_score_total' => $stats['first_to_score_total'] ?? $stats['home_first_to_score_total'] ?? $stats['away_first_to_score_total'] ?? 1,
                'streak_first_to_concede_success' => $stats['first_to_concede_success'] ?? $stats['away_first_to_concede_success'] ?? 0,
                'streak_first_to_concede_total' => $stats['first_to_concede_total'] ?? $stats['away_first_to_concede_total'] ?? 1,
                'streak_first_half_winner_success' => $stats['first_half_winner_success'] ?? $stats['home_first_half_winner_success'] ?? $stats['away_first_half_winner_success'] ?? 0,
                'streak_first_half_winner_total' => $stats['first_half_winner_total'] ?? $stats['home_first_half_winner_total'] ?? $stats['away_first_half_winner_total'] ?? 1,
                'streak_first_half_loser_success' => $stats['first_half_loser_success'] ?? $stats['away_first_half_loser_success'] ?? 0,
                'streak_first_half_loser_total' => $stats['first_half_loser_total'] ?? $stats['away_first_half_loser_total'] ?? 1,
                'streak_both_teams_score_success' => $stats['both_teams_score_success'] ?? $stats['home_both_teams_score_success'] ?? $stats['away_both_teams_score_success'] ?? 0,
                'streak_both_teams_score_total' => $stats['both_teams_score_total'] ?? $stats['home_both_teams_score_total'] ?? $stats['away_both_teams_score_total'] ?? 1,
                'streak_no_defeats_success' => $stats['no_defeats_success'] ?? $stats['home_no_defeats_success'] ?? 0,
                'streak_no_defeats_total' => $stats['no_defeats_total'] ?? $stats['home_no_defeats_total'] ?? 1,
                'streak_no_wins_success' => $stats['no_wins_success'] ?? $stats['away_no_wins_success'] ?? 0,
                'streak_no_wins_total' => $stats['no_wins_total'] ?? $stats['away_no_wins_total'] ?? 1,
                'last_updated' => now()
            ]
        );
    }

    public function getTeamsByLeague(Request $request)
    {
        $teams = Team::where('league_id', $request->league_id)->get();
        return response()->json($teams);
    }
}