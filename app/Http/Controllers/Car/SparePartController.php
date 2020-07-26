<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Model\Car\Spare_part;
use App\Model\Service\Notification;
use Illuminate\Http\Request;
use App\Model\Service\Photo;
use App\Model\Car\Car;
use App\User;
use Auth;
use DB;


class SparePartController extends Controller
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

        $photos = json_decode($fetchedData['photo'],true);
        $spraeCreated=Spare_part::create([
            'description' => $fetchedData['description'],
            'title' => $fetchedData['title'],
            'price' => $fetchedData['price'],
            'photo' => $photos[0],
            'address' => $fetchedData['address'],
            'status' => 1, //pending
            'car_id' => $fetchedData['car_id'],
            'car_model_id' => $fetchedData['car_model_id'],
            'user_id' => Auth::User()->id
        ])->wasRecentlyCreated;

        if($spraeCreated)
        {
            $spareId = DB::table('spare_parts')->latest('id')->first()->id;
            for($i=1;$i<sizeof($photos);$i++)
            {
                $photoCreated = Photo::create([
                    'object_id'   => $spareId,
                    'type'         => 1,
                    'name'         => $photos[$i],
                ])->wasRecentlyCreated;
            }
        }

        if($spraeCreated && $photoCreated)
            return response()->json(["massge" => "Store Successfully"],200);

        else
            return response()->json(["massge" =>" Failed to Store"],400);
    }


    public function showSparePart()
    {
        try 
        {
            $spareParts = Spare_part::getAllSparePart(2);
        return response()->json($spareParts ,200);
        
        } 
        catch (Exception $e)
        {
            return response()->json($e->getMessage);
        }
        
    }

    public function pendingSparePart()
    {
        $spareParts = Spare_Part::getAllSparePart(1);
        return response()->json($spareParts,200);
    }

    public function acceptOrRejectSP(Request $request)
    {
        $fetchedData = $request->all();

        $isEdited = Spare_Part::where('id',$fetchedData['id'])->update([
            'status' => $fetchedData['status']
        ]);

        $sparePart = Spare_Part::find($fetchedData['id']);

        if($isEdited)
        {
            if($fetchedData['status']==2)
            {
                Notification::create([
                    'message' => 'Your Spare Part '.$sparePart['title'].' has been approved',
                    'user_id' => $sparePart['user_id'],
                    'seen'    =>  0
                ]);
            }

            if($fetchedData['status']==0)
            {
                Notification::create([
                    'message' => 
                    'Your Spare Part '.$sparePart['title'].' has been Rejected because  '.$fetchedData['rejection_reason'].'',
                    'user_id' => $sparePart['user_id'],
                    'seen'    =>  0
                ]);
                Spare_Part::where('id',$fetchedData['id'])->update([
                    'rejection_reason' => $fetchedData['rejection_reason']
                ]);
            }
            return response()->json(["massge" => "Edit Successfully"],200);
        }
        else
            return response()->json(["massge" =>" Failed to Edit"],400);
    }

    public function search(Request $request)
    {
        $fetchedData = $request->all();


        if($fetchedData['car']==0)
            $spareParts= Spare_Part::where('status','2')
            ->where('title', 'LIKE', '%' . $fetchedData['input'] . '%')
            //->where('price','<',$fetchedData['price_max'])
           // ->where('price','>',$fetchedData['price_min'])
            ->orderBy($fetchedData['sortby'],$fetchedData['sortvalue'])->paginate(10);

        if($fetchedData['car']!=0 && $fetchedData['car_model']==0)
            $spareParts = Spare_Part::where('status','2')
            ->where('title', 'LIKE', '%' . $fetchedData['input'] . '%')
            ->where('car_id',$fetchedData['car'])
           // ->where('price','<',$fetchedData['price_max'])
            //->where('price','>',$fetchedData['price_min'])
            ->orderBy($fetchedData['sortby'],$fetchedData['sortvalue'])->paginate(10);

        if($fetchedData['car']!=0 && $fetchedData['car_model']!=0)
            $spareParts = Spare_Part::where('status','2')
            ->where('title', 'LIKE', '%' . $fetchedData['input'] . '%')
            ->where('car_id',$fetchedData['car'])
            ->where('car_model_id',$fetchedData['car_model'])
            //->where('price','<',$fetchedData['price_max'])
           //->where('price','>',$fetchedData['price_min'])
            ->orderBy($fetchedData['sortby'],$fetchedData['sortvalue'])->paginate(10);

        for($i=0 ;$i<sizeof($spareParts); $i++)
        {
            $spareParts[$i]['created_date'] =$spareParts[$i]['created_at']->format('Y-m-d');
            $spareParts[$i]['user_name']=$spareParts[$i]->user->name;
            $spareParts[$i]['user_photo']=$spareParts[$i]->user->photo;
            $spareParts[$i]['user_phonenumber']=$spareParts[$i]->user->phonenumber;
            $spareParts[$i]['car_name']=$spareParts[$i]->car->name;
            $spareParts[$i]['car_model_name']=$spareParts[$i]->car_model->name;
            $spareParts[$i]['photos'] = Photo::select('name')->where('type',1)
            ->where('object_id',$spareParts[$i]['id'])->get();
            unset($spareParts[$i]['user']);
            unset($spareParts[$i]['car']);
            unset($spareParts[$i]['car_model']);
        }

        return response()->json($spareParts,200);
    }

}
