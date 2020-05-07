<?php

namespace App\Model\Maintenance;

use Illuminate\Database\Eloquent\Model;
use App\Model\Maintenance\Maintenance_Type;
use Illuminate\Http\Request;
use App\User;
use DB;

class Maintenance_Center extends Model
{
    protected $guarded = [];
    public $table = "maintenance_centers";

    public static function getALLM_Center(Request $request)
    {
        $latitude=$request->latitude;
        $longitude=$request->longitude;

        $m_Centers =DB::select('select * , 
        ( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude )
         - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) 
        AS distance FROM maintenance_centers GROUP BY id 
         HAVING ( 6367 * acos( cos( radians('.$latitude.') ) * 
         cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) 
         + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) < 25');

        /*foreach($m_Centers as $m_Center)
        {
            $m_Center['user_name'] = $m_Center->user->name;
            unset($m_Center['user']);
        }*/
        
        return $m_Centers;
    }

    /*
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
    */


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}   
