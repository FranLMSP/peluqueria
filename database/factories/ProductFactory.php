<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'price' => $faker->randomFloat(1, 0, 1000000),
        'active' => true,
        'product_header_id' => factory(App\ProductHeader::class)->create()->id
    ];
});
