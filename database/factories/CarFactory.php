<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Model\Car\Car;
use Faker\Generator as Faker;

$factory->define(Car::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
