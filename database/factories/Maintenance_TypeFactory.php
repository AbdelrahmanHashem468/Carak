<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Maintenance\Maintenance_Type;
use Faker\Generator as Faker;

$factory->define(Maintenance_Type::class, function (Faker $faker) {
    return [
        'logo' => $faker->name,
        'name' => $faker->name,
    ];
});
