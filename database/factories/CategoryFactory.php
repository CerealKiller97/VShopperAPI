<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Category::class, function (Faker $faker) {
    return [
        'name'        => $faker->word,
        'account_id'  => rand(1, 5),
        'category_id' => null,
        'image_id'    => rand(1, 5)
    ];
});
