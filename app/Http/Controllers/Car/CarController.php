<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Model\Car\Car_For_Sell;
use Illuminate\Http\Request;
use App\Model\Car\Car_Price;
use App\Model\Car\Car;
use App\User;
use Auth;

class CarController extends Controller
{
    
    public function addCarForSell(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request, [
            'title' => 'required|min:3',
            'description' => 'required|min:3',
            'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'price' => 'required',
            'address' => 'required',
            'year' => 'required|digits:4',
            'car_status' => 'required',
            'car_id' => 'required',
            'car_model_id' => 'required',
        ]);

        if($fetchedData['car_status'] == 'used')
            $car_status = 0;
        if($fetchedData['car_status'] == 'new')
            $car_status = 1;

        $isCreated=Car_For_Sell::create([
            'description' => $fetchedData['description'],
            'title' => $fetchedData['title'],
            'price' => $fetchedData['price'],
            'photo' => User::fileUpload($request),
            'address' => $fetchedData['address'],
            'year' => $fetchedData['year'],
            'car_status' => $car_status,
            'status' => 1, //pending
            'car_id' => $fetchedData['car_id'],
            'car_model_id' => $fetchedData['car_model_id'],
            'user_id' => Auth::User()->id
        ])->wasRecentlyCreated;

        if($isCreated)
            return response()->json(["massge" => "Store Successfully"],200);

        else
            return response()->json(["massge" =>" Failed to Store"],400);
    }

    public function showCarsForSell()
    {
        $carForSell = Car_For_Sell::getAllCar();
        return response()->json($carForSell ,200);
    }

    public function addCarPrice(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request, [
            
            'price' => 'required',
            'category' => 'required',
            'car_id' => 'required',
            'car_model_id' => 'required',
        ]);

        $isCreated=Car_Price::create([
            'price' => $fetchedData['price'],
            'category' => $fetchedData['category'],
            'car_id' => $fetchedData['car_id'],
            'car_model_id' => $fetchedData['car_model_id'],
        ])->wasRecentlyCreated;

        if($isCreated)
            return response()->json(["massge" => "Store Successfully"],200);

        else
            return response()->json(["massge" =>" Failed to Store"],400);
    }

    public function showCarPrice()
    {
        $carPrice = Car_Price::getAllCarPrice();
        return response()->json($carPrice ,200);
    }


    public function showCarModel()
    {
        $carModel = Car::getCarModel();
        return response()->json($carModel ,200);
    }


    public function test()
    {
        $car = Car::find(7);
        return $car->car_model;
    }
}
