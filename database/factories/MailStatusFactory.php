<?php

use Faker\Generator as Faker;

$factory->define(App\MailStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
        'active' => $faker->numberBetween(0, 1) ? false : true
    ];
});
