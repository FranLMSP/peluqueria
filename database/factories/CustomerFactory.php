<?php

use Faker\Generator as Faker;
use App\Customer;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'names' => $faker->name,
        'surnames' => $faker->name,
        'identity_number' => $faker->randomNumber,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'birthdate' => $faker->date
    ];
});
