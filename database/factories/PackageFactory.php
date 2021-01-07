<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Package;
use Faker\Generator as Faker;

$factory->define(Package::class, function (Faker $faker) {
    return [
        'customer_name' => $faker->name,
		'customer_address' => $faker->streetAddress,
		'customer_email' => $faker->unique()->safeEmail,
		'customer_phone' => $faker->e164PhoneNumber,
		'customer_zip_code' => $faker->postcode,
		'customer_zone_code' => $faker->state,
		'destination_name' => $faker->name,
		'destination_address' => $faker->streetAddress,
		'destination_phone' => $faker->e164PhoneNumber,
		'destination_address_detail' => $faker->address,
		'destination_zip_code' => $faker->postcode,
		'destination_zone_code' => $faker->state,
		'amount' => $faker->randomNumber,
    ];
});
