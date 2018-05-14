<?php

use Faker\Generator as Faker;
use App\Product;
use App\Employee;

$factory->define(App\Commission::class, function (Faker $faker) {
    return [
        'service_id' => Product::all()->random()->id,
        'employee_id' => Employee::all()->random()->id,
        'percentage' => $faker->numberBetween(0,100)
    ];
});
