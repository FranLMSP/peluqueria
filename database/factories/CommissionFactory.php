<?php

use Faker\Generator as Faker;
use App\Product;
use App\Employee;

$factory->define(App\Commission::class, function (Faker $faker) {
    return [
        'service_id' => Product::where('active', true)
            ->whereHas('definition', function($query){
                $query->whereType('S');
            })->get()->random()->id,
        'employee_id' => Employee::all()->random()->id,
        'percentage' => $faker->numberBetween(0,100)
    ];
});
