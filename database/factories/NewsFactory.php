<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Service\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->text,
        'photo' => 'https://res.cloudinary.com/cark/image/upload/v1586258373/rdnokj4vf7ir4flrsfml.jpg'
    ];
});
