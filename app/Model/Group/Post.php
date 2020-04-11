<?php

namespace App\Model\Group;

use Illuminate\Database\Eloquent\Model;
use App\Model\Group\Group;
use App\Model\Group\Reply;
use App\User;

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

    public static function getPostsByGroupId($id)
    {
        $posts = Group::find($id)->post()->orderBy('created_at','desc')->paginate(10);
        for($i=0;$i<sizeof($posts);$i++)
        {
            $posts[$i]['created_date'] =$posts[$i]['created_at']->format('Y-m-d');
            $posts[$i]['user_name'] = $posts[$i]->user->name;
            $posts[$i]['user_photo'] = $posts[$i]->user->photo;
            unset($posts[$i]['user']);
        }
        return $posts;
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function reply()
    {
        return $this->hasMany(Reply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

