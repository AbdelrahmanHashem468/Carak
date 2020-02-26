<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Car\Car;
use App\Model\Car\Car_Model;
use Faker\Generator as Faker;

$factory->define(Car_Model::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'car_id' =>Car::getInstance(),
    ];
});
