<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MatchScrapingService;

class ScrapingTestController extends Controller
{
    private $scrapingService;

    public function __construct(MatchScrapingService $scrapingService)
    {
        $this->scrapingService = $scrapingService;
    }

    public function testSofaScore(Request $request)
    {
        $url = $request->get('url', 'https://www.sofascore.com/es/football/match/chelsea-manchester-united/mcYb#id:14025169');

        $result = $this->scrapingService->scrapeMatchData($url);

        // Organizar datos para mejor visualización
        $organizedData = [
            'match_info' => [
                'home_team' => $result['home_team_name'] ?? 'No encontrado',
                'away_team' => $result['away_team_name'] ?? 'No encontrado',
                'league' => $result['league_name'] ?? 'No encontrado',
                'match_date' => $result['match_date'] ?? 'No encontrado'
            ],
            'win_percentages' => [
                'home_win' => ($result['home_win_percent'] ?? 0) . '%',
                'draw' => ($result['draw_percent'] ?? 0) . '%',
                'away_win' => ($result['away_win_percent'] ?? 0) . '%'
            ],
            'home_team_stats' => [
                'winning_streak' => $result['home_winning_streak'] ?? 'N/A',
                'losing_streak' => $result['home_losing_streak'] ?? 'N/A',
                'unbeaten_streak' => $result['home_unbeaten_streak'] ?? 'N/A',
                'no_clean_sheet_streak' => $result['home_no_clean_sheet_streak'] ?? 'N/A',
                'first_to_score' => $result['home_first_to_score'] ?? 'N/A',
                'first_half_winner' => $result['home_first_half_winner'] ?? 'N/A',
                'both_teams_score' => $result['home_both_teams_score'] ?? 'N/A',
                'over_25_goals' => $result['home_over_25_goals'] ?? 'N/A',
                'under_25_goals' => $result['home_under_25_goals'] ?? 'N/A'
            ],
            'away_team_stats' => [
                'winning_streak' => $result['away_winning_streak'] ?? 'N/A',
                'losing_streak' => $result['away_losing_streak'] ?? 'N/A',
                'unbeaten_streak' => $result['away_unbeaten_streak'] ?? 'N/A',
                'no_clean_sheet_streak' => $result['away_no_clean_sheet_streak'] ?? 'N/A',
                'first_to_score' => $result['away_first_to_score'] ?? 'N/A',
                'first_half_winner' => $result['away_first_half_winner'] ?? 'N/A',
                'both_teams_score' => $result['away_both_teams_score'] ?? 'N/A',
                'over_25_goals' => $result['away_over_25_goals'] ?? 'N/A',
                'under_25_goals' => $result['away_under_25_goals'] ?? 'N/A'
            ]
        ];

        return response()->json([
            'url_tested' => $url,
            'scraping_successful' => !isset($result['error']),
            'has_real_streaks' => isset($result['home_winning_streak']) && is_numeric($result['home_winning_streak']),
            'data_source' => isset($result['home_winning_streak']) && is_numeric($result['home_winning_streak']) ? 'SofaScore API' : 'Fallback/Estimated',
            'data' => $organizedData,
            'debug_info' => [
                'event_id_found' => isset($result['event_id']) ? $result['event_id'] : 'Not extracted',
                'api_calls_made' => isset($result['api_calls']) ? $result['api_calls'] : 'Unknown',
                'errors' => isset($result['error']) ? $result['error'] : 'None'
            ],
            'raw_result' => $result,
            'timestamp' => now()
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function form()
    {
        return view('test-scraping');
    }
}
