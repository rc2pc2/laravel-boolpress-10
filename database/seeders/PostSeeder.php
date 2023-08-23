<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i=0; $i < 100; $i++) {
            $newPost = new Post();
            $newPost->title = ucfirst($faker->unique()->words(4, true));
            $newPost->content = $faker->paragraphs(10, true);
            $newPost->slug = $faker->unique()->slug();
            $newPost->image = $faker->imageUrl(480, 360, 'post', true, 'posts', true, 'png');
            $newPost->save();
        }
    }
}
