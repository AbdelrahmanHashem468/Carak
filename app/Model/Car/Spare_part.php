<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;
use App\Model\Car\Car_Model;
use App\Model\Car\Car;
use App\User;


class Spare_part extends Model
{
    protected $guarded = [];
    const UPDATED_AT = null;


    public static function getAllSparePart()
    {
        $spareParts = Spare_part::where('status','2')
        ->orderBy('created_at','desc')->get();
        
        for($i=0 ;$i<sizeof($spareParts); $i++)
        {
            /*
            $spareParts[$i]['user_name']=$spareParts[$i]->user->name;
            $spareParts[$i]['car_name']=$spareParts[$i]->car->name;
            $spareParts[$i]['car_model_name']=$spareParts[$i]->car_model->name;
            */
            $userId = $spareParts[$i]['user_id'];
            $spareParts[$i]['user_name']= User::find($userId)->name;
            
            $carId = $spareParts[$i]['car_id'];
            $spareParts[$i]['car_name']= Car::find($carId)->name;
            
            $carModelId = $spareParts[$i]['car_model_id'];
            $spareParts[$i]['car_model_name']= Car_Model::find($carModelId)->name;
        }
        return $spareParts;
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
