<?php

use Faker\Generator as Faker;
use App\Customer;
use App\MailStatus;

$factory->define(App\Mail::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'subject' => $faker->sentence,
        'message' => $faker->sentence,
        'customer_id' => Customer::get()->random()->id,
        'status_id' => MailStatus::get()->random()->id
    ];
});
