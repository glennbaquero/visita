<?php

use Faker\Generator as Faker;

use App\Helpers\SeederHelpers;

$factory->define(App\Models\TrainingModules\TrainingModule::class, function (Faker $faker) {
    return [
        'destination_id' => '1',
        'title' => $faker->word(3),
        'description' => $faker->paragraph,
        'path' => SeederHelpers::randomFile(),
    ];
});
