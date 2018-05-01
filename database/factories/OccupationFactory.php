<?php

use Faker\Generator as Faker;

$factory->define(App\Occupation::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence
    ];
});
