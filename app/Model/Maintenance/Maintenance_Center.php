<?php

namespace App\Model\Maintenance;

use Illuminate\Database\Eloquent\Model;
use App\Model\Maintenance\Maintenance_Type;
use App\User;

class Maintenance_Center extends Model
{
    protected $guarded = [];
    public $table = "maintenance_centers";


    public static function getALLM_CenterByM_TypeId($id)
    {
        $m_Center = Maintenance_Type::find($id)->maintenance_center
        ->where('status',2);

        /*for($i=0;$i<sizeof($m_Center);$i++)
        {
            $m_Center[$i]['user_name'] = $m_Center[$i]->user->name;
            unset($m_Center[$i]['user']);
        }*/
        return $m_Center;
    }

    public function maintenance_type()
    {
        return $this->belongsTo(Maintenance_Type::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}   
