<?php

namespace App\Http\Controllers\Maintenance;

use App\Model\Maintenance\Maintenance_Center;
use App\Model\Maintenance\Maintenance_Type;
use App\Model\Service\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class MaintenanceController extends Controller
{
    public function showM_Types()
    {
        $m_Type = Maintenance_Type::getAllM_Types();
        return response()->json($m_Type,200);
    }


    public function showM_Centers(Request $request)
    {
        $m_Center = Maintenance_Center::getALLM_Center($request);
        return response()->json($m_Center,200);
    }


    public function addM_Center(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request,[
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'maintenance_type' => 'required'
        ]);

        $centerCreated = Maintenance_Center::create([
            'name'                => $fetchedData['name'],
            'latitude'          => $fetchedData['latitude'],
            'longitude'          => $fetchedData['longitude'],
            'status'              => 1,   
            'maintenance_type' => $fetchedData['maintenance_type'],
            'number' => $fetchedData['number'],
            'photo' => $fetchedData['photo'],
            'idphoto1' => $fetchedData['idphoto1'],
            'idphoto2' => $fetchedData['idphoto2'],
            'user_id'             => Auth::User()->id    
        ])->wasRecentlyCreated;

        if($centerCreated)
        {
            return response()->json(["massage"=>"Store Successfully"],200);
        }
        else
        {
            return response()->json(["massage"=>"Failed to Store"],400);
        }
    }

    public function pendingM_Centers()
    {
        $m_Center = Maintenance_Center::getPendingM_Center();
        return response()->json($m_Center,200);
    }

    public function acceptOrRejectMC(Request $request)
    {
        $fetchedData = $request->all();

        $isEdited = Maintenance_Center::where('id',$fetchedData['id'])->update([
            'status' => $fetchedData['status']
        ]);

        $maintenanceCenter = Maintenance_Center::find($fetchedData['id']);


        if($isEdited)
        {
            if($fetchedData['status']==2)
            {
                Notification::create([
                    'message' => ' '.$maintenanceCenter['name'].'  لقد تم الموافقه علي مركز الصيانة ',
                    'user_id' => $maintenanceCenter['user_id'],
                    'seen'    =>  0
                ]);
            }

            if($fetchedData['status']==0)
            {
                Notification::create([
                    'message' => 
                    ' بسبب '.$fetchedData['rejection_reason'].' '.$maintenanceCenter['title'].'   لقد تم رفض مركز الصيانة  ',
                    'user_id' => $maintenanceCenter['user_id'],
                    'seen'    =>  0
                ]);
                Maintenance_Center::where('id',$fetchedData['id'])->update([
                    'rejection_reason' => $fetchedData['rejection_reason']
                ]);
            }
            return response()->json(["massge" => "Edit Successfully"],200);
        }
            else
            return response()->json(["massge" =>" Failed to Edit"],400);
    }

}
