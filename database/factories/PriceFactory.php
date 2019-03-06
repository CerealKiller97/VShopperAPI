<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Price::class, function (Faker $faker) {
    return [
        'product_id' => rand(1, 5),
        'amount'     => rand(1000, 10000),

    ];
});
