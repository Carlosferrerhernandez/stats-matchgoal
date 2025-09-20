<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RealLeaguesAndTeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar datos existentes
        Team::query()->delete();
        League::query()->delete();

        // LaLiga Española
        $laliga = League::create([
            'name' => 'LaLiga EA Sports',
            'country' => 'España',
            'description' => 'Primera División del fútbol español, una de las ligas más competitivas del mundo.',
        ]);

        $laligaTeams = [
            ['name' => 'Real Madrid', 'city' => 'Madrid', 'founded_year' => 1902],
            ['name' => 'FC Barcelona', 'city' => 'Barcelona', 'founded_year' => 1899],
            ['name' => 'Atlético de Madrid', 'city' => 'Madrid', 'founded_year' => 1903],
            ['name' => 'Real Sociedad', 'city' => 'San Sebastián', 'founded_year' => 1909],
            ['name' => 'Real Betis', 'city' => 'Sevilla', 'founded_year' => 1907],
            ['name' => 'Sevilla FC', 'city' => 'Sevilla', 'founded_year' => 1890],
            ['name' => 'Valencia CF', 'city' => 'Valencia', 'founded_year' => 1919],
            ['name' => 'Athletic Bilbao', 'city' => 'Bilbao', 'founded_year' => 1898],
            ['name' => 'Villarreal CF', 'city' => 'Villarreal', 'founded_year' => 1923],
            ['name' => 'Getafe CF', 'city' => 'Getafe', 'founded_year' => 1983],
            ['name' => 'Real Mallorca', 'city' => 'Palma', 'founded_year' => 1916],
            ['name' => 'Girona FC', 'city' => 'Girona', 'founded_year' => 1930],
        ];

        foreach ($laligaTeams as $teamData) {
            Team::create([
                'name' => $teamData['name'],
                'league_id' => $laliga->id,
                'city' => $teamData['city'],
                'founded_year' => $teamData['founded_year'],
            ]);
        }

        // Premier League
        $premier = League::create([
            'name' => 'Premier League',
            'country' => 'Inglaterra',
            'description' => 'La primera división del fútbol inglés, conocida por su intensidad y competitividad.',
        ]);

        $premierTeams = [
            ['name' => 'Manchester City', 'city' => 'Manchester', 'founded_year' => 1880],
            ['name' => 'Arsenal FC', 'city' => 'Londres', 'founded_year' => 1886],
            ['name' => 'Liverpool FC', 'city' => 'Liverpool', 'founded_year' => 1892],
            ['name' => 'Manchester United', 'city' => 'Manchester', 'founded_year' => 1878],
            ['name' => 'Chelsea FC', 'city' => 'Londres', 'founded_year' => 1905],
            ['name' => 'Tottenham Hotspur', 'city' => 'Londres', 'founded_year' => 1882],
            ['name' => 'Newcastle United', 'city' => 'Newcastle', 'founded_year' => 1892],
            ['name' => 'Brighton FC', 'city' => 'Brighton', 'founded_year' => 1901],
        ];

        foreach ($premierTeams as $teamData) {
            Team::create([
                'name' => $teamData['name'],
                'league_id' => $premier->id,
                'city' => $teamData['city'],
                'founded_year' => $teamData['founded_year'],
            ]);
        }

        // Serie A
        $serieA = League::create([
            'name' => 'Serie A TIM',
            'country' => 'Italia',
            'description' => 'La primera división del fútbol italiano, famosa por su defensa táctica.',
        ]);

        $serieATeams = [
            ['name' => 'Juventus', 'city' => 'Turín', 'founded_year' => 1897],
            ['name' => 'AC Milan', 'city' => 'Milán', 'founded_year' => 1899],
            ['name' => 'Inter de Milán', 'city' => 'Milán', 'founded_year' => 1908],
            ['name' => 'AS Roma', 'city' => 'Roma', 'founded_year' => 1927],
            ['name' => 'Lazio', 'city' => 'Roma', 'founded_year' => 1900],
            ['name' => 'Napoli', 'city' => 'Nápoles', 'founded_year' => 1926],
            ['name' => 'Atalanta', 'city' => 'Bérgamo', 'founded_year' => 1907],
            ['name' => 'Fiorentina', 'city' => 'Florencia', 'founded_year' => 1926],
        ];

        foreach ($serieATeams as $teamData) {
            Team::create([
                'name' => $teamData['name'],
                'league_id' => $serieA->id,
                'city' => $teamData['city'],
                'founded_year' => $teamData['founded_year'],
            ]);
        }

        // Bundesliga
        $bundesliga = League::create([
            'name' => 'Bundesliga',
            'country' => 'Alemania',
            'description' => 'La primera división del fútbol alemán, conocida por su organización y ambiente.',
        ]);

        $bundesligaTeams = [
            ['name' => 'Bayern Munich', 'city' => 'Múnich', 'founded_year' => 1900],
            ['name' => 'Borussia Dortmund', 'city' => 'Dortmund', 'founded_year' => 1909],
            ['name' => 'RB Leipzig', 'city' => 'Leipzig', 'founded_year' => 2009],
            ['name' => 'Union Berlin', 'city' => 'Berlín', 'founded_year' => 1966],
            ['name' => 'Freiburg', 'city' => 'Friburgo', 'founded_year' => 1904],
            ['name' => 'Bayer Leverkusen', 'city' => 'Leverkusen', 'founded_year' => 1904],
            ['name' => 'Eintracht Frankfurt', 'city' => 'Frankfurt', 'founded_year' => 1899],
            ['name' => 'Wolfsburg', 'city' => 'Wolfsburg', 'founded_year' => 1945],
        ];

        foreach ($bundesligaTeams as $teamData) {
            Team::create([
                'name' => $teamData['name'],
                'league_id' => $bundesliga->id,
                'city' => $teamData['city'],
                'founded_year' => $teamData['founded_year'],
            ]);
        }

        $this->command->info('Seeder ejecutado: ' . League::count() . ' ligas y ' . Team::count() . ' equipos creados.');
    }
}