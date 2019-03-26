<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Storage::class, function (Faker $faker) {
    return [
        'address'         => $faker->streetAddress,
        'size'            => rand(1, 100),
        'storage_type_id' => rand(1, 2),
        'account_id'      => rand(1, 5)
    ];
});
