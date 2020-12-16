<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entry;
use Faker\Generator as Faker;

$factory->define(Entry::class, function (Faker $faker) {
    return [
        'patient_id' => 1,
        'date' => now(),
        'time' => now(),
        'actual_disease' => Str::random(10),
        'date_of_symptoms' => now(),
        'date_of_diagnosis' => now(),
        'date_of_admission' => now(),
        'date_of_death' => now(),
        'date_of_exit' => now(),    
    ];
});
