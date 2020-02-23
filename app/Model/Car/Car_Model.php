<?php

namespace App\Model\Car;
use Illuminate\Database\Eloquent\Model;

class Car_Model extends Model
{
    public $table = "car_models";
    protected $guarded = [];

    public static function getAllCarsModel()
    {
        return Car_Model::all();
    }

    public static function getInstance()
    {
        $carsModel = Car_Model::getAllCarsModel();
        if(sizeof($carsModel)>0)
        {
            $rendValue=rand(0,sizeof($carsModel)-1);
            $array = [
                'id' => $carsModel[$rendValue]['id'],
                'car_id'=> $carsModel[$rendValue]['car_id'],
            ];
            return $array ;
        }
    }
/*
    public function Car()
    {
        return $this->belongsTo('Car');
    }
*/
}
