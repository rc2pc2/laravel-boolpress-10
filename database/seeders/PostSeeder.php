<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        $categoryIds = Category::all()->pluck('id');
        $userIds = User::all()->pluck('id');
        $tagIds = Tag::all()->pluck('id')->toArray();

        for ($i=0; $i < 1000; $i++) {
            $newPost = new Post();
            $newPost->category_id = $faker->randomElement($categoryIds);
            $newPost->user_id = $faker->randomElement($userIds);
            $newPost->title = ucfirst($faker->unique()->words(4, true));
            $newPost->content = $faker->paragraphs(10, true);
            $newPost->image = $faker->imageUrl(480, 360, 'post', true, 'posts', true, 'png');
            $newPost->slug = Str::of($newPost->title)->slug('-');
            $newPost->save();
            $newPost->slug = Str::of("$newPost->id " . $newPost->title)->slug('-');
            $newPost->save();

            $newPost->tags()->sync([$faker->randomElement($tagIds), $faker->randomElement($tagIds), $faker->randomElement($tagIds) ]);

        }
    }
}
