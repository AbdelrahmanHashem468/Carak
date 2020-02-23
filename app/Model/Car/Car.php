<?php

namespace App\Model\Car;
use App\Model\Car\Car_Model;
use Illuminate\Database\Eloquent\Model;

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
/*
    public function car_model()
    {
        return $this->hasMany('Car_Model');
    }
    */
}
