<?php

namespace App\Model\Group;
use Illuminate\Database\Eloquent\Model;
use App\Model\Group\Post;
use App\Model\Car\Car;

class Group extends Model
{
    protected $guarded = [] ;


    public static function getAllGroups()
    {
        $groups = Group::all();
        for($i=0;$i<sizeof($groups);$i++)
        {
            $groups[$i]['group_name'] = $groups[$i]->car->name;
            unset($groups[$i]['car']);
        }
        return $groups;
    }

    public static function getInstance()
    {
        $groups = Group::all();
        if(sizeof($groups)>0)
            return $groups[rand(0,sizeof($groups)-1)]['id'];
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}