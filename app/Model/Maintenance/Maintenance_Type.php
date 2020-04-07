<?php

namespace App\Model\Maintenance;

use Illuminate\Database\Eloquent\Model;
use App\Model\Maintenance\Maintenance_Center;

class Maintenance_Type extends Model
{
    protected $guarded = [];
    public $table = "maintenance_types";


    public static function getAllM_Types()
    {
        return Maintenance_Type::all();
    }

    public static function getInstance()
    {
        $maintenanceTypes = Maintenance_Type::getAllM_Types();
        if(sizeof($maintenanceTypes)>0)
            return $maintenanceTypes[rand(0,sizeof($maintenanceTypes)-1)]['id'];
    }
}
