<?php

namespace App\Model\Car;
use Illuminate\Database\Eloquent\Model;
use App\Model\Car\Car;
use App\Model\Car\Spare_part;
use App\Model\Car\Car_For_Sell;
use App\Model\Car\Car_Price;

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

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function spare_part()
    {
        return $this->hasMany(Spare_part::class,'car_model_id');
    }

    public function car_for_sell()
    {
        return $this->hasMany(Car_For_Sell::class);
    }

    public function car_price()
    {
        return $this->belongsTo(Car_Price::class);
    }
}
