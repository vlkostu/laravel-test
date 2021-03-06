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

        $episodes->each(function ($episode) use ($characters) {
            # Rand characters
            $charactersRandom = $characters->random(rand(5, 15));
            # Sync characters
            $episode->characters()->attach($charactersRandom);
            # Sync quotes
            $charactersRandom->each(function ($character) use ($episode) {
                # Generate quotes
                Quote::factory(rand(3, 7))->make()->each(function ($quote) use ($character, $episode) {
                    $quote->character()->associate($character);
                    $quote->episode()->associate($episode);
                    $quote->save();
                });
            });
        });
    }
}
