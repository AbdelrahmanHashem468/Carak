<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Maintenance\Maintenance_Center;
use App\Model\Maintenance\Maintenance_Type;
use App\User;
use Faker\Generator as Faker;

$factory->define(Maintenance_Center::class, function (Faker $faker) {
    $rand = rand(0,2);
    return [
        'name' => $faker->name,
        'location' => $faker->word,
        'status' => $rand,
        'user_id' => User::getInstance(),
        'maintenance_type_id' => Maintenance_Type::getInstance(),

    ];
});
