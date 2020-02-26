<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Group\Group;
use App\Model\Car\Car;

use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'car_id'=>Car::getInstance(),
    ];
});
