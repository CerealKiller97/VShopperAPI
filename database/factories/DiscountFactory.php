<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(App\Models\Discount::class, function (Faker $faker) {
    return [
        'product_id'  => rand(1, 5),
        'amount'      => rand(1000, 10000),
        'valid_from'  => Carbon::now(),
        'valid_until' =>Carbon::create(rand(2019, 2022), 12, 25, 14, 15, 16)
    ];
});
