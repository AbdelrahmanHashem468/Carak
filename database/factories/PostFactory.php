<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Group\Post;
use App\Model\Group\Group;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'text' => $faker->text,
        'group_id' => Group::getInstance(),
        'user_id' => User::getInstance(),
    ];
});
