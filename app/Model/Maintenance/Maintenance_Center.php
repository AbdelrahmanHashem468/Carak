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
         + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) < 25 and status = 2');

        for($i=0 ;$i<sizeof($m_Centers); $i++)        
        {
            $array = get_object_vars($m_Centers[$i]);
            $m_Centers[$i]->user_name = User::find($array['user_id'])->name;
            
        }
        
        return $m_Centers;
    }


    public static function getPendingM_Center()
    {
        $m_Centers = Maintenance_Center::where('status','1')->paginate(10);
        for($i=0;$i<sizeof($m_Centers);$i++)
        {
            $m_Centers[$i]['user_name'] = $m_Centers[$i]->user->name;
            unset($m_Centers[$i]['user']);
        }
        return $m_Centers;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}   
