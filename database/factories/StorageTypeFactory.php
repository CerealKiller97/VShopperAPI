<?php

use Faker\Generator as Faker;

$factory->define(App\Models\StorageType::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
