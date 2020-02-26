<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;
use App\Model\Car\Car_Model;
use App\Model\Car\Car;
use App\User;


class Car_For_Sell extends Model
{
    protected $guarded = [];
    public $table = "car_for_sells";
    const UPDATED_AT = null;


    public static function getAllCar()
    {
        $cars = Car_For_Sell::where('status','2')
        ->orderBy('created_at','desc')->get();
        
        for($i=0 ;$i<sizeof($cars); $i++)
        {
            /*
            $cars[$i]['user_name']=$cars[$i]->user->name;
            $cars[$i]['car_name']=$cars[$i]->car->name;
            $cars[$i]['car_model_name']=$cars[$i]->car_model->name;
            */
            $userId = $cars[$i]['user_id'];
            $cars[$i]['user_name']= User::find($userId)->name;
            
            $carId = $cars[$i]['car_id'];
            $cars[$i]['car_name']= Car::find($carId)->name;
            
            $carModelId = $cars[$i]['car_model_id'];
            $cars[$i]['car_model_name']= Car_Model::find($carModelId)->name;
        }
        return $cars;
    }



    public function user()
    {
        return $this->belongsTo(User::class);
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


