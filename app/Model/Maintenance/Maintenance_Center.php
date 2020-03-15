<?php

namespace App\Model\Maintenance;

use Illuminate\Database\Eloquent\Model;
use App\Model\Maintenance\Maintenance_Type;

class Maintenance_Center extends Model
{
    protected $guarded = [];
    public $table = "maintenance_centers";


    public static function getALLM_CenterByM_TypeId($id)
    {
        $m_Center = Maintenance_Type::find($id)->maintenance_center
        ->where('status',2);
        return $m_Center;
    }

    public function maintenance_type()
    {
        return $this->belongsTo(Maintenance_Type::class);
    }
}   
