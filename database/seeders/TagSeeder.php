<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $tags = [
            'php', 'vue', 'food', 'funny',
            'dark-humour', 'for-me', 'for-you'
        ];

        foreach ($tags as $tag){
            $newTag = new Tag();
            $newTag->name = $tag;
            $newTag->color = $faker->unique()->safeHexColor();
            $newTag->save();
        }
    }
}
