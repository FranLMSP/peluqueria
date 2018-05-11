<?php

use Faker\Generator as Faker;
use App\ProductHeader;

$factory->define(ProductHeader::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'type' => $faker->numberBetween(0,1) == 1 ? 'P' : 'S',
        'description' => $faker->sentence
    ];
});
