<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Evolution;
use Faker\Generator as Faker;

$factory->define(Evolution::class, function (Faker $faker) {
    return [
        'hospitalization_id' => 1,
        'user_id' => 1,
        'temperature' => 1,
        'heart_rate' => 1,
        'breathing_rate' => 1,
        'systolic_ta' => 1,
        'diastolic_ta' => 1,
    ];
});
