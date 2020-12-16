<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Hospitalization;
use Faker\Generator as Faker;

$factory->define(Hospitalization::class, function (Faker $faker) {
    return [
        'entry_id' => 1,
        'system_id' => 1,
    ];
});
