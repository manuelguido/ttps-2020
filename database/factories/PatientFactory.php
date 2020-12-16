<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use Faker\Generator as Faker;

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'lastname' => $faker->lastname,
        'email' => $faker->unique()->safeEmail,
        'address' => Str::random(10),
        'phone' => mt_rand(1000000, 99999999),
        'dni' => mt_rand(1000000, 99999999),
        'birth_date' => now(),
        'system_id' => 1,
        'patient_state_id' => 1,
        'medical_ensurance_id' => 1,
        'contact_name' => $faker->name,
        'contact_lastname' => $faker->lastname,
        'contact_phone' => mt_rand(1000000, 99999999),
    ];
});
