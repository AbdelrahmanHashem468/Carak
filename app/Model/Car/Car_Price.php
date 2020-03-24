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
        $carsPrices = Car::getCarModel();
        foreach($carsPrices as $carsPrice)
        {
            foreach($carsPrice['car_models'] as $car)
            {
                $car['car_price'] =$car->car_price;
            }
        }
        return $carsPrices;
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
