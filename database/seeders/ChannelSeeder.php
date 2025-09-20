<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = [
            ['name' => 'Bet365'],
            ['name' => 'Betfair'],
            ['name' => 'William Hill'],
            ['name' => 'Betsson'],
            ['name' => 'Codere'],
            ['name' => 'Sportium'],
            ['name' => 'Bwin'],
            ['name' => 'Betway']
        ];

        foreach ($channels as $channel) {
            \App\Models\Channel::updateOrCreate(
                ['name' => $channel['name']],
                $channel
            );
        }

        $this->command->info('Channels seeded successfully!');
    }
}
