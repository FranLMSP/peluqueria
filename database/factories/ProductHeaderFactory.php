<?php

use Faker\Generator as Faker;
use App\ProductHeader;

$factory->define(ProductHeader::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence
    ];
});
