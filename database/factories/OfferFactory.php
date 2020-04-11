<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Service\Offer;
use App\User;
use Faker\Generator as Faker;

$factory->define(Offer::class, function (Faker $faker) {
    $rand=rand(0,2);
    return [
        'title' => $faker->name,
        'description' => $faker->text,
        'photo' => 'https://res.cloudinary.com/cark/image/upload/v1584853653/vs2qb4smgv9ekubgjvmo.jpg',
        'status' => $rand,
        'user_id'=>User::getInstance(),
    ];
});
