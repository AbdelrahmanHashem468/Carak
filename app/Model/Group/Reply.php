<?php

namespace App\Model\Group;

use Illuminate\Database\Eloquent\Model;
use App\Model\Group\Post;
use App\Model\Group\Like;
use App\User;

class Reply extends Model
{
    Protected $guarded = [];


    public static function getAllReply()
    {
        return Reply::all();
    }

    public static function getInstance()
    {
        $replies = Reply::getAllReply();
        if(sizeof($replies)>0)
        {
            $rendValue=rand(0,sizeof($replies)-1);
            $array = [
                'id' => $replies[$rendValue]['id'],
                'post_id'=> $replies[$rendValue]['post_id'],
            ];
            return $array ;
        }
    }

    Public static function getRepliesByPostId($id)
    {
        $replies = Post::find($id)->reply()->orderBy('created_at','desc')->paginate(10);
        for($i=0;$i<sizeof($replies);$i++)
        {
            $replies[$i]["user_name"] = $replies[$i]->user->name;
            $replies[$i]["user_photo"] = $replies[$i]->user->photo;
            $replies[$i]['created_date'] =$replies[$i]['created_at']->format('Y-m-d');
            $replies[$i]["likes"] = count($replies[$i]->like);
            unset($replies[$i]["user"]);
            unset($replies[$i]["like"]);

        }
        return $replies ;
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }
}