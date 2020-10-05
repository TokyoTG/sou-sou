<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PaymentMethod;
use Faker\Generator as Faker;

$factory->define(PaymentMethod::class, function (Faker $faker) {
    return [
        //
        'platform' => 'CashApp',
        'details' => $faker->sentence,
        'user_name' => 'Prof. Jeffery Kreiger',
        'contact' => $faker->randomNumber(9),
        'user_id' => 1
    ];
});
