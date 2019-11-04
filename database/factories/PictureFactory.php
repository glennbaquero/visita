<?php

use Faker\Generator as Faker;

use App\Helpers\SeederHelpers;

$factory->define(App\Models\Picture::class, function (Faker $faker) {
    return [
        'image_path' => SeederHelpers::randomFile(),
    ];
});
