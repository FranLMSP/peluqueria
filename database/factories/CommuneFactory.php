<?php

use Faker\Generator as Faker;
use App\Region;

$factory->define(App\Commune::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'region_id' => Region::all()->random()->id
    ];
});
