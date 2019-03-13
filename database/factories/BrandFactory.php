<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Brand::class, function (Faker $faker) {
    return [
        'name'       => $faker->word,
        'account_id' => rand(1, 5),
        'image_id'   => rand(1, 5)
    ];
});
