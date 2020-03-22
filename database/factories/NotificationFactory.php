<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Model\Service\Notification;
use Faker\Generator as Faker;

$factory->define(Notification::class, function (Faker $faker) {
    return [
        'message' => $faker->text,
        'seen' => rand(0,1),
        'user_id' => User::getInstance(),
    ];
});
