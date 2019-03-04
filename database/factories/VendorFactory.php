<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Vendor::class, function (Faker $faker) {
    return [
        'name'       => $faker->company,
        'address'    => $faker->address,
        'pib'        => $faker->ean8,
        'phone'      => $faker->e164PhoneNumber,
        'email'      => $faker->unique()->safeEmail,
        'account_id' => rand(1, 5)
    ];
});
