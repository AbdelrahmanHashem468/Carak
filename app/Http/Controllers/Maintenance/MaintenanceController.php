<?php

namespace App\Http\Controllers\Maintenance;

use App\Model\Maintenance\Maintenance_Center;
use App\Model\Maintenance\Maintenance_Type;
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


    public function showM_Centers()
    {
        $m_Center = Maintenance_Center::getALLM_Center();
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


}
