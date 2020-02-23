<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Model\Car\Car_Model;
use App\Model\Car\Car_Price;
use Faker\Generator as Faker;

$factory->define(Car_Price::class, function (Faker $faker) {
    $Instance = Car_Model::getInstance() ;
    return [
        'price' => $faker->randomNumber(5),
        'category' => $faker->name,
        'car_id' => $Instance['car_id'],
        'car_model_id'=> $Instance['id'],
    ];
});
