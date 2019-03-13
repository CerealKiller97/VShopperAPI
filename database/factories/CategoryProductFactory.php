<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CategoryProduct::class, function (Faker $faker) {
    return [
        'product_id'   => rand(1, 5),
        'category_id'  => rand(1, 5)
    ];
});
