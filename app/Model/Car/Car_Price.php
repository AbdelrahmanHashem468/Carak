<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;
use App\Model\Car\Car_Model;
use App\Model\Car\Car;

class Car_Price extends Model
{
    protected $guarded = [];
    public $table = "car_prices" ;


    public static function getAllCarPrice()
    {
        $carsPrices = Car::getAllCars();
        foreach($carsPrices as $carsPrice)
        {
            $carsPrice['car_price']=$carsPrice->car_price;
            foreach($carsPrice['car_price'] as $car)
            {
                $car['car_model_name']=$car->car_model->name;
                unset($car['car_model']);
            }
        }
        return $carsPrices;
        /*foreach($carsPrices as $carsPrice)
        {
            foreach($carsPrice['car_models'] as $car)
            {
                $car['car_price'] =$car->car_price;
            }
        }*/
        
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function car_model()
    {
        return $this->belongsTo(Car_Model::class);
    }
}
