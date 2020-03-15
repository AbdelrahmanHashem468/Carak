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


    public function showM_Centers($id)
    {
        $m_Center = Maintenance_Center::getALLM_CenterByM_TypeId($id);
        return response()->json($m_Center,200);
    }


    public function addM_Center(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request,[
            'name' => 'required',
            'x_location' => 'required',
            'y_location' => 'required',
            'maintenance_type_id' => 'required'
        ]);

        $centerCreated = Maintenance_Center::create([
            'name'                => $fetchedData['name'],
            'x_location'          => $fetchedData['x_location'],
            'y_location'          => $fetchedData['y_location'],
            'status'              => 1,   
            'maintenance_type_id' => $fetchedData['maintenance_type_id'],
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
