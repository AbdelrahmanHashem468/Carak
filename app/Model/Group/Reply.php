<?php

namespace App\Model\Group;

use Illuminate\Database\Eloquent\Model;

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
}