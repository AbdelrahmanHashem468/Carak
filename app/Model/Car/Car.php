<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;
use App\Model\Car\Car_For_Sell;
use App\Model\Car\spare_part;
use App\Model\Car\Car_Model;
use App\Model\Car\Car_Price;

class Car extends Model
{
    protected $guarded = [];

    public static function getAllCars()
    {
        return Car::all();
    }

    public static function getInstance()
    {
        $cars = Car::getAllCars();
        if(sizeof($cars)>0)
            return $cars[rand(0,sizeof($cars)-1)]['id'];
    }

    public static function getCarModel()
    {
        $cars = Car::paginate(50);
        $car_model=$cars;
        for($i=0 ;$i<sizeof($cars); $i++)
        {
            $car_model[$i]=array(
                $cars[$i]->name => $cars[$i]->car_model,
                'car_id' => $cars[$i]->id,
            );
        }
        return $car_model;
    }

    public function car_model()
    {
        return $this->hasMany(Car_Model::class);
    }


    public function spare_part()
    {
        return $this->hasMany(Spare_part::class);
    }

    public function car_for_sell()
    {
        return $this->hasMany(Car_For_Sell::class);
    }

    public function car_price()
    {
        return $this->hasMany(Car_Price::class);
    }
}
