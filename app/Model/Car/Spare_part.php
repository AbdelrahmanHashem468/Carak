<?php

namespace App\Model\Car;
use App\User;
use App\Model\Car\Car;
use App\Model\Car\Car_Model;
use Illuminate\Database\Eloquent\Model;

class Spare_part extends Model
{
    protected $guarded = [];
    const UPDATED_AT = null;


    public static function getAllSparePart()
    {
        return Spare_part::orderBy('created_at','desc')->get();
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
