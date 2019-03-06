<?php

use Faker\Generator as Faker;

$factory->define(App\Models\DiscountGroup::class, function (Faker $faker) {
    return [
        'discount_id' => rand(1, 5),
        'group_id'    => rand(1, 2)
    ];
});
