<?php

use Faker\Generator as Faker;

$factory->define(App\TransactionType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
        'io' => $faker->numberBetween(0,1) == 1 ? 'I' : 'O'
    ];
});
