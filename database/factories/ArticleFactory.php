<?php

use Faker\Generator as Faker;

use App\Helpers\SeederHelpers;

$factory->define(App\Models\Articles\Article::class, function (Faker $faker) {
    return [
        'name' => $faker->word(3),
        'description' => $faker->paragraph,
        'image_path' => SeederHelpers::randomFile(),
        'published_at' => now(),
    ];
});
