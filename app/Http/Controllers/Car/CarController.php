<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Model\Car\Spare_part;
use App\Model\Car\Car;


class CarController extends Controller
{
    public function addSparePart(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request, [
            'title' => 'required|min:3',
            'description' => 'required|min:3',
            'photo'=>'required',
            'price' => 'required',
            'address' => 'required',
            'car_id' => 'required',
            'car_model_id' => 'required',
        ]);

        $isCreated=Spare_part::create([
            'description' => $fetchedData['description'],
            'title' => $fetchedData['title'],
            'price' => $fetchedData['price'],
            'photo' => $fetchedData['photo'],
            'address' => $fetchedData['address'],
            'status' => 1, //pending
            'car_id' => $fetchedData['car_id'],
            'car_model_id' => $fetchedData['car_model_id'],
            'user_id' => Auth::User()->id
        ])->wasRecentlyCreated;

        if($isCreated)
            return response()->json(["massge" => "Store Successfully"],200);

        else
        {
            return response()->json(["massge" =>" Failed to Store"],400);
        }
    }


    public function showSparePart()
    {
        $spareParts = Spare_part::getAllSparePart();
        return response()->json($spareParts ,200);
    }



    public function test()
    {
        $car = Car::find(5);
        return $car->spare_part;
    }
}
