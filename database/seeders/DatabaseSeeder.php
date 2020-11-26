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
        $episodes = Episode::factory(30)->create();
        $characters = Character::factory(100)->create();

        $episodes->each(function ($episode) use ($characters) {
            $episode->characters()->attach(
                $characters->random(rand(5, 15))
            );
        });

        $episodesCount = $episodes->count();

        $characters->each(function ($character) use ($episodes, $episodesCount) {
            Quote::factory(rand(3, 7))->create([
                'episode_id' => rand(1, $episodesCount),
                'character_id' => $character->id
            ]);
        });
    }
}
