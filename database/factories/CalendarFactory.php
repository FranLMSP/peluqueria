<?php

use Faker\Generator as Faker;
use App\Customer;
use App\Product;
use App\ProductHeader;
use App\CalendarStatus;
use App\Employee;

$factory->define(App\Calendar::class, function (Faker $faker) {
    return [
        'customer_id' => Customer::all()->random()->id,
        'service_id' => Product::where('active', true)
	        ->whereHas('definition', function($query){
	            $query->whereType('S');
	        })->get()->random()->id,
        'employee_id' => Employee::all()->random()->id,
        'status_id' => CalendarStatus::all()->random()->id,
        'notes' => $faker->sentence,
        'date' => $faker->date
    ];
});
