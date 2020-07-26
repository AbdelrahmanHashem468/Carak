<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Maintenance\Maintenance_Center;
use App\Model\Maintenance\Maintenance_Type;
use App\User;
use Faker\Generator as Faker;

$factory->define(Maintenance_Center::class, function (Faker $faker) {
    $rand = rand(0,2);
    $rand2 = rand(0,12);
    return [
        'name' => $faker->name,
        'latitude' => $faker->randomFloat(2, 1, 100 ),
        'longitude' => $faker->randomFloat(2, 1, 100 ),
        'status' => $rand,
        'user_id' => User::getInstance(),
        'maintenance_type' => $rand2,
    ];
});
