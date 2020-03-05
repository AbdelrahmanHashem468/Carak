<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Group\Reply;
use App\Model\Group\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'text' => $faker->text,
        'post_id' => Post::getInstance(),
        'user_id' => User::getInstance(),
    ];
});
