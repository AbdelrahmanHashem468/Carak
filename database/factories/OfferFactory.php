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
        'photo' => 'https://res.cloudinary.com/cark/image/upload/v1595782679/kccphfkzv1poktl9y8m1.jpg',
        'status' => $rand,
        'user_id'=>User::getInstance(),
    ];
});
