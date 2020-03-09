<?php

namespace App\Model\Car;

use Illuminate\Database\Eloquent\Model;
use App\Model\Car\Car_Model;
use App\Model\Service\Photo;
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
        ->orderBy('created_at','desc')->paginate(50);
        
        for($i=0 ;$i<sizeof($cars); $i++)
        {
            if ($cars[$i]['car_status']==0)
                $cars[$i]['car_status']= 'used';
            if ($cars[$i]['car_status']==1)
                $cars[$i]['car_status']= 'new';
            $cars[$i]['user_name']=$cars[$i]->user->name;
            $cars[$i]['car_name']=$cars[$i]->car->name;
            $cars[$i]['car_model_name']=$cars[$i]->car_model->name;
            $cars[$i]['photos'] =
                Photo::where('type',2)->where('object_id',$cars[$i]['id'])->get();
            unset($cars[$i]['user']);
            unset($cars[$i]['car']);
            unset($cars[$i]['car_model']);
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


