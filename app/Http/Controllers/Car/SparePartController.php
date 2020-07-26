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

}
