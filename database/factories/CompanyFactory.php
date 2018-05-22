<?php

use Faker\Generator as Faker;
use App\Commune;

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
		'address' => $faker->address,
		'commune_id' => Commune::all()->random()->id,
		'phone' => $faker->phoneNumber,
		'secondary_phone' => $faker->phoneNumber,
		'email' => $faker->email,
		'website' => $faker->email,
		'shortname' => $faker->name,
		'color' => '#FFFFFF',
		'boxes' => $faker->numberBetween(1, 30)
    ];
});
