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
        $m_Centers = Maintenance_Type::find($id)->maintenance_center
        ->where('status',2);
        
        foreach($m_Centers as $m_Center)
        {
            $m_Center['user_name'] = $m_Center->user->name;
            unset($m_Center['user']);
        }
        
        return $m_Centers;
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
