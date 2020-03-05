<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Group\Reply;
use App\Model\Group\Like;
use App\User;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    $instance = Reply::getInstance();
    return [
        'post_id' => $instance['post_id'],
        'reply_id' => $instance['id'],
        'user_id' => User::getInstance(),
    ];
});
