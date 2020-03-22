<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Model\Service\Solar_Price;
use App\Model\Service\Notification;
use App\Model\Service\Advertise;
use App\Model\Service\Report;
use Illuminate\Http\Request;
use App\Model\Service\Photo;
use App\Model\Service\Offer;
use App\Model\Service\News;
use Auth;
use DB;

class ServiceController extends Controller
{
    public function showOffers()
    {
        $offers = Offer::getAllOffers();
        return response()->json($offers,200);
    }

    public function addOffer(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required'
        ]);

        $photos = json_decode($fetchedData['photo'],true);
        $offerCreated = Offer::create([
            'title'               => $fetchedData['title'],
            'description'         => $fetchedData['description'],
            'photo'               => $photos[0],
            'status'              => 1,
            'user_id'             => Auth::User()->id
        ])->wasRecentlyCreated;

        if($offerCreated)
        {
            $offerId = DB::table('offers')->latest('id')->first()->id;
            for($i=1;$i<sizeof($photos);$i++)
            {
                $photoCreated = Photo::create([
                    'object_id'   => $offerId,
                    'type'        => 3,
                    'name'        => $photos[$i],
                ])->wasRecentlyCreated;
            }
        }

        if($offerCreated && $photoCreated)
        {
            return response()->json(["massage"=>"Store Successfully"],200);
        }
        else
        {
            return response()->json(["massage"=>"Failed to Store"],400);
        }
    }

    public function addReport(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request,[
            'message' => 'required'
        ]);

        $reportCreated = Report::create([
            'message' => $fetchedData['message'],
            'user_id' => Auth::User()->id
        ])->wasRecentlyCreated;

        if($reportCreated)
        {
            return response()->json(["massage"=>"Store Successfully"],200);
        }
        else
        {
            return response()->json(["massage"=>"Failed to Store"],400);
        }
    }

    public function showNews()
    {
        $news = News::all();
        return response()->json($news,200);
    }

    public function showAdvertises()
    {
        $advertises = Advertise::all();
        return response()->json($advertises,200);
    }

    public function showSolarPrice()
    {
        $solarPrice = Solar_Price::all();
        return response()->json($solarPrice,200);
    }

    public function showNotification($id)
    {
        $notifications = Notification::getAllNotifications($id);
        return response()->json($notifications,200);
    }
}
