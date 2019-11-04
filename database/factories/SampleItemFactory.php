<?php

use Faker\Generator as Faker;

use App\Helpers\SeederHelpers;

$factory->define(App\Models\Samples\SampleItem::class, function (Faker $faker) {
    return [
        'name' => $faker->word(3),
        'description' => $faker->paragraph,
        'image_path' => SeederHelpers::randomFile(),
        'date' => now(),
        'dates' => [now()->toDateString(), now()->addDays(2)->toDateString()],
    ];
});
