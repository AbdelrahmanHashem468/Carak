<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Car\Spare_part;
use App\Model\Car\Car_Model;
use App\User;
use Faker\Generator as Faker;

$factory->define(Spare_part::class, function (Faker $faker) {
    $Instance = Car_Model::getInstance() ;
    $rand=rand(0,2);
    return [
        'title' => $faker->title(),
        'description' => $faker->text,
        'price' => $faker->randomNumber(5),
        'address' => $faker->address,
        'status' =>$rand,
        'photo' => $faker->name,
        'car_id' => $Instance['car_id'],
        'car_model_id'=> $Instance['id'],
        'user_id'=>User::getInstance(),

    ];
});
