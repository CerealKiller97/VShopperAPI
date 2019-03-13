<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'account_id' => rand(1, 5),
        'unit_id'    => rand(1, 2),
        'brand_id'   => rand(1, 5),
        'vendor_id'   => rand(1, 5),
        'name' => $faker->word,
        'description' => $faker->realText
    ];
});
