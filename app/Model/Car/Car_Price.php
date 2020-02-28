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
        $carsPrice = Car_Price::orderBy('created_at','desc')->paginate(50);
        
        for($i=0 ;$i<sizeof($carsPrice); $i++)
        {
            
            $carsPrice[$i]['car_name']=$carsPrice[$i]->car->name;
            $carsPrice[$i]['car_model_name']=$carsPrice[$i]->car_model->name;
            unset($carsPrice[$i]['car']);
            unset($carsPrice[$i]['car_model']);
        }
        return $carsPrice;
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
