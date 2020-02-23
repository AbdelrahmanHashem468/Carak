<?php

namespace App\Model\Group;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [] ;


    public static function getAllGroups()
    {
        return Group::all();
    }

    public static function getInstance()
    {
        $groups = Group::getAllGroups();
        if(sizeof($groups)>0)
            return $groups[rand(0,sizeof($groups)-1)]['id'];
    }
}