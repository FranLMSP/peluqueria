<?php

use Faker\Generator as Faker;

$factory->define(App\CalendarStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence
    ];
});
