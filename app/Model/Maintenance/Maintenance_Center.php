<?php

namespace App\Model\Maintenance;

use Illuminate\Database\Eloquent\Model;
use App\Model\Maintenance\Maintenance_Type;
use App\User;

class Maintenance_Center extends Model
{
    protected $guarded = [];
    public $table = "maintenance_centers";


    public static function getALLM_Center()
    {
        $m_Centers = Maintenance_Center::where('status',2)->get();
        
        foreach($m_Centers as $m_Center)
        {
            $m_Center['user_name'] = $m_Center->user->name;
            unset($m_Center['user']);
        }
        
        return $m_Centers;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}   
