<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Car\Car_For_Sell;
use App\Model\Car\Car_Model;
use App\User;
use Faker\Generator as Faker;

$factory->define(Car_For_Sell::class, function (Faker $faker) {
    $Instance = Car_Model::getInstance() ;
    $rand1=rand(0,1);
    $rand2=rand(0,2);
    return [
        'title' => $faker->name,
        'description' => $faker->text,
        'price' => $faker->randomNumber(5),
        'address' => $faker->address,
        'car_status' =>$rand1,
        'status' =>$rand2,
        'year' => $faker->randomNumber(4),
        'photo' => 'https://res.cloudinary.com/cark/image/upload/v1595782679/kccphfkzv1poktl9y8m1.jpg',
        'car_id' => $Instance['car_id'],
        'car_model_id'=> $Instance['id'],
        'user_id'=>User::getInstance(),

    ];
});
