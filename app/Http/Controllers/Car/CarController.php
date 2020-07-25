<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Model\Car\Car_For_Sell;
use Illuminate\Http\Request;
use App\Model\Service\Photo;
use App\Model\Group\Group;
use App\Model\Car\Car_Price;
use App\Model\Car\Car_Model;
use App\Model\Car\Car;
use App\User;
use Auth;
use DB;
class CarController extends Controller
{
    
    public function addCarForSell(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request, [
            'title' => 'required|min:3',
            'description' => 'required|min:3',
            'photo'=>'required',
            'price' => 'required',
            'address' => 'required',
            'year' => 'required|digits:4',
            'car_status' => 'required',
            'car_id' => 'required',
            'car_model_id' => 'required',
        ]);

        $photos = json_decode($fetchedData['photo'],true);

        $carCreated=Car_For_Sell::create([
            'description'   => $fetchedData['description'],
            'title'         => $fetchedData['title'],
            'price'         => $fetchedData['price'],
            'photo'         => $photos[0],
            'address'       => $fetchedData['address'],
            'year'          => $fetchedData['year'],
            'car_status'    => $fetchedData['car_status'],
            'status'        => 1, //pending
            'car_id'        => $fetchedData['car_id'],
            'car_model_id'  => $fetchedData['car_model_id'],
            'user_id'       => Auth::User()->id
        ])->wasRecentlyCreated;

        if($carCreated)
        {
            $carId = DB::table('car_for_sells')->latest('id')->first()->id;
            for($i=1;$i<sizeof($photos);$i++)
            {
                $photoCreated = Photo::create([
                    'object_id'   => $carId,
                    'type'         => 2,
                    'name'         => $photos[$i],
                ])->wasRecentlyCreated;
            }
        }

        if($carCreated && $photoCreated)
            return response()->json(["massge" => "Store Successfully"],200);
        else
            return response()->json(["massge" =>" Failed to Store"],400);
    }

    public function showNewCars()
    {
        $carForSell = Car_For_Sell::getAllCar(2,1);
        return response()->json($carForSell ,200);
    }

    public function showUsedCars()
    {
        $carForSell = Car_For_Sell::getAllCar(2,0);
        return response()->json($carForSell ,200);
    }

    public function pendingNewCars()
    {
        $carForSell = Car_For_Sell::getAllCar(1,1);
        return response()->json($carForSell,200);
    }

    public function pendingUsedCars()
    {
        $carForSell = Car_For_Sell::getAllCar(1,0);
        return response()->json($carForSell,200);
    }

    public function acceptOrRejectCar(Request $request)
    {
        $fetchedData = $request->all();

        $isEdited = Car_For_Sell::where('id',$fetchedData['id'])->update([
            'status' => $fetchedData['status']
        ]);

        if($isEdited)
        return response()->json(["massge" => "Edit Successfully"],200);

        else
            return response()->json(["massge" =>" Failed to Edit"],400);
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


    public function getAllUsers()
    {
        $users = User::paginate(10);
        return response()->json($users ,200);
    }

    public function addCar(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request, [
            'name' => 'required'
        ]);

        $isCreated = Car::create([
            'name' => $fetchedData['name'],
        ])->wasRecentlyCreated;

        $car = Car::where('name',$fetchedData['name'])->get();
        
        $groupCreated = Group::create([
            'car_id' => $car[0]['id'],
        ])->wasRecentlyCreated;

        
        if($isCreated && $groupCreated)
            return response()->json(["massge" => "Store Successfully"],200);
        else
            return response()->json(["massge" =>" Failed to Store"],400);
    }

    public function addCarModel(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request, [
            'name' => 'required',
            'car_id' => 'required'
        ]);

        $isCreated=Car_Model::create([
            'name' => $fetchedData['name'],
            'car_id' => $fetchedData['car_id'],
        ])->wasRecentlyCreated;

        
        if($isCreated)
            return response()->json(["massge" => "Store Successfully"],200);
        else
            return response()->json(["massge" =>" Failed to Store"],400);
    }
}
