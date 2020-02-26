<?php

namespace App\Model\Group;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public static function getAllPosts()
    {
        return Post::all();
    }

    public static function getInstance()
    {
        $posts = Post::getAllPosts();
        if(sizeof($posts)>0)
            return $posts[rand(0,sizeof($posts)-1)]['id'];
    }
}

