<?php

use Faker\Generator as Faker;
use App\Occupation;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'names' => $faker->name,
        'surnames' => $faker->name,
        'identity_number' => $faker->randomNumber,
        'birthdate' => $faker->date,
        'occupation_id' => factory(Occupation::class)->create()
    ];
});
