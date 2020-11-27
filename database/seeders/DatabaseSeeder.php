<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Episode;
use App\Models\Quote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        # Create episodes
        $episodes = Episode::factory(30)->create();
        # Create characters
        $characters = Character::factory(100)->create();
        # Count episodes
        $episodesCount = $episodes->count();

        $episodes->each(function ($episode) use ($characters, $episodesCount) {
            # Rand characters
            $characters = $characters->random(rand(5, 15));
            # Sync characters
            $episode->characters()->attach($characters);
            # Sync quotes
            $characters->each(function ($character) use ($episode, $episodesCount) {
                # Generate quotes
                $quotes = Quote::factory(rand(3, 7))->create([
                    'episode_id' => rand(1, $episodesCount),
                    'character_id' => $character->id
                ]);
                # Sync character and episode
                $character->quotes()->saveMany($quotes);
                $episode->quotes()->saveMany($quotes);
            });
        });
    }
}
