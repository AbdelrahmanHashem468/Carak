<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Model\Car\Car_For_Sell;
use App\Model\Car\Spare_part;
use Illuminate\Http\Request;
use App\Model\Service\Photo;
use App\Model\Group\Group;
use App\Model\Car\Car_Price;
use App\Model\Car\Car_Model;
use App\Model\Car\Car;
use App\User;
use Auth;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function newCarForSellSearch(Request $request)
    {
        $fetchedData = $request->all();
        $result = $this->search($fetchedData,1);
        return response()->json($result);
    }

    public function usedCarForSellSearch(Request $request)
    {
        $fetchedData = $request->all();
        $result = $this->search($fetchedData,0);
        return response()->json($result);
    }


    public function search($fetchedData,$car_status)
    {
        if($fetchedData['car']==0)
            $carForSell= Car_For_Sell::where('status','2')
            ->where('car_status',$car_status)
            ->where('title', 'LIKE', '%' . $fetchedData['input'] . '%')
            ->where('price','<',$fetchedData['price_max'])
            ->where('price','>',$fetchedData['price_min'])
            ->orderBy($fetchedData['sortby'],$fetchedData['sortvalue'])->paginate(10);

        if($fetchedData['car']!=0 && $fetchedData['car_model']==0)
            $carForSell = Car_For_Sell::where('status','2')
            ->where('car_status',$car_status)
            ->where('title', 'LIKE', '%' . $fetchedData['input'] . '%')
            ->where('car_id',$fetchedData['car'])
            ->where('price','<',$fetchedData['price_max'])
            ->where('price','>',$fetchedData['price_min'])
            ->orderBy($fetchedData['sortby'],$fetchedData['sortvalue'])->paginate(10);

        if($fetchedData['car']!=0 && $fetchedData['car_model']!=0)
            $carForSell = Car_For_Sell::where('status','2')
            ->where('car_status',$car_status)
            ->where('title', 'LIKE', '%' . $fetchedData['input'] . '%')
            ->where('car_id',$fetchedData['car'])
            ->where('car_model_id',$fetchedData['car_model'])
            ->where('price','<',$fetchedData['price_max'])
            ->where('price','>',$fetchedData['price_min'])
            ->orderBy($fetchedData['sortby'],$fetchedData['sortvalue'])->paginate(10);

        for($i=0 ;$i<sizeof($carForSell); $i++)
        {
            $carForSell[$i]['created_date'] =$carForSell[$i]['created_at']->format('Y-m-d');
            $carForSell[$i]['user_name']=$carForSell[$i]->user->name;
            $carForSell[$i]['user_photo']=$carForSell[$i]->user->photo;
            $carForSell[$i]['user_phonenumber']=$carForSell[$i]->user->phonenumber;
            $carForSell[$i]['car_name']=$carForSell[$i]->car->name;
            $carForSell[$i]['car_model_name']=$carForSell[$i]->car_model->name;
            $carForSell[$i]['photos'] = Photo::select('name')->where('type',2)
            ->where('object_id',$carForSell[$i]['id'])->get();
            unset($carForSell[$i]['user']);
            unset($carForSell[$i]['car']);
            unset($carForSell[$i]['car_model']);
        }

        return $carForSell;
    }


/*
    public function usedCarForSellSearch(Request $request)
    {
        $fetchedData = $request->all();
        $result = $this->search1($fetchedData,'car_for_sells',0);
        return response()->json($result);
    }

    public function newCarForSellSearch(Request $request)
    {
        $fetchedData = $request->all();
        $result = $this->search1($fetchedData,'car_for_sells',1);
        return response()->json($result);
    }


    public function search($fetchedData,$table)
    {
        $qr = "select * From  ".$table."  where status = 2";
        $where = '';

        if($fetchedData['input']!= Null)
        {
            $where = $where." title LIKE '%".$fetchedData['input']."%'";
        }

        if($fetchedData['car']!= Null)
        {
                if($where!='')
                    $where = $where.' and ';
            $where = $where." car_id = ".$fetchedData['car'];
        }

        if($fetchedData['car_model']!= Null)
        {
                if($where!='')
                    $where = $where.' and ';
            $where = $where." car_model_id = ".$fetchedData['car_model'];
        }

        if($fetchedData['price_min']!= Null)
        {
                if($where!='')
                    $where = $where.' and ';
                $where = $where." price > '".$fetchedData['price_min']."'";
                }

        if($fetchedData['price_max']!= Null)
        {
                if($where!='')
                    $where = $where.' and ';
                $where = $where." price < '".$fetchedData['price_max']."'";
                }

        if($where !='')
            $qr = $qr.' and '.$where;

        if($fetchedData['sort_date'] =='ASC' || $fetchedData['sort_date'] =='DESC')
            $qr = $qr.' order by created_at '.$fetchedData['sort_date'];

        if($fetchedData['sort_price'] =='ASC' || $fetchedData['sort_price'] =='DESC')
            $qr = $qr.' order by price '.$fetchedData['sort_price'];

            $result=DB::select( $qr);
            $collect = collect($result);

            $page = 1;
            $size = 10;
            $paginationData = new LengthAwarePaginator(
                $collect->forPage($page, $size),
                $collect->count(), 
                $size, 
                $page,
                ['path' => url('https://rocky-cliffs-25615.herokuapp.com/api/sparePartSearch')]
                                );

        return $paginationData;
    }

    public function search1($fetchedData,$table,$car_status)
    {
        $qr = "select * From  ".$table."  where status = 2 and car_status = ".$car_status."";
        $where = '';

        if($fetchedData['input']!= Null)
        {
            $where = $where." title LIKE '%".$fetchedData['input']."%'";
        }

        if($fetchedData['car']!= Null)
        {
                if($where!='')
                    $where = $where.' and ';
            $where = $where." car_id = ".$fetchedData['car'];
        }

        if($fetchedData['car_model']!= Null)
        {
                if($where!='')
                    $where = $where.' and ';
            $where = $where." car_model_id = ".$fetchedData['car_model'];
        }

        if($fetchedData['price_min']!= Null)
        {
            
                if($where!='')
                    $where = $where.' and ';
            $where = $where." price > '".$fetchedData['price_min']."'";
        }

        if($fetchedData['price_max']!= Null)
        {
                if($where!='')
                    $where = $where.' and ';
            $where = $where." price < '".$fetchedData['price_max']."'";
        }

        if($where !='')
            $qr = $qr.' and '.$where;

        if($fetchedData['sort_date'] =='ASC' || $fetchedData['sort_date'] =='DESC')
            $qr = $qr.' order by created_at '.$fetchedData['sort_date'];

        if($fetchedData['sort_price'] =='ASC' || $fetchedData['sort_price'] =='DESC')
            $qr = $qr.' order by price '.$fetchedData['sort_price'];

        $result=DB::select( $qr);
        $collect = collect($result);

        $page = 1;
        $size = 10;
        if($car_status==1)
        {
            $paginationData = new LengthAwarePaginator(
                $collect->forPage($page, $size),
                $collect->count(), 
                $size,
                $page,
                ['path' => url('https://rocky-cliffs-25615.herokuapp.com/api/newCarForSellSearch')]
                                );
        }

        if($car_status==0)
        {
            $paginationData = new LengthAwarePaginator(
                $collect->forPage($page, $size),
                $collect->count(), 
                $size,
                $page,
                ['path' => url('https://rocky-cliffs-25615.herokuapp.com/api/usedCarForSellSearch')]
                                );
        }
        return $paginationData;
    }
*/

}
