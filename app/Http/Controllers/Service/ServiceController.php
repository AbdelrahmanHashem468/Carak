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
use App\User;
use Auth;
use DB;

class ServiceController extends Controller
{
    public function showOffers()
    {
        $offers = Offer::getAllOffers(2);
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

    public function pendingOffers()
    {
        $offers = Offer::getAllOffers(1);
        return response()->json($offers,200);
    }

    public function acceptOrRejectOffer(Request $request)
    {
        $fetchedData = $request->all();

        $isEdited = Offer::where('id',$fetchedData['id'])->update([
            'status' => $fetchedData['status']
        ]);

        $offer = Offer::find($fetchedData['id']);

        if($isEdited)
        {
            if($fetchedData['status']==2)
            {
                Notification::create([
                    'message' => ' '.$offer['title'].'  لقد تم الموافقه علي اعلانك ',
                    'user_id' => $offer['user_id'],
                    'seen'    =>  0
                ]);
            }

            if($fetchedData['status']==0)
            {
                Notification::create([
                    'message' => 
                    ' بسبب '.$fetchedData['rejection_reason'].' '.$offer['title'].'   لقد تم رفض اعلانك ',
                    'user_id' => $offer['user_id'],
                    'seen'    =>  0
                ]);
                Offer::where('id',$fetchedData['id'])->update([
                    'rejection_reason' => $fetchedData['rejection_reason']
                ]);
            }
            return response()->json(["massge" => "Edit Successfully"],200);
        }
        else
            return response()->json(["massge" =>" Failed to Edit"],400);
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
    public function showReport()
    {
        $reports = Report::paginate(10);
        for($i=0;$i<sizeof($reports);$i++)
        {
            $user = User::find($reports[$i]['user_id']);
            $reports[$i]['user_name'] = $user->name;
            $reports[$i]['user_email'] = $user->email;
            $reports[$i]['user_number'] = $user->phonenumber;
            $reports[$i]['user_photo'] = $user->photo;


        }
        return response()->json($reports,200);

    }

    public function showNews()
    {
        $news = News::paginate(10);
        return response()->json($news,200);
    }

    public function addNews(Request $request)
    {
        $fetchedData = $request->all();

        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required',
        ]);

        $url = User::fileUpload($request);
        
        $newsCreated = News::create([
            'title' => $fetchedData['title'],
            'description' => $fetchedData['description'],
            'photo' => $url
        ])->wasRecentlyCreated;

        if($newsCreated)
        {
            return response()->json(["massage"=>"Store Successfully"],200);
        }
        else
        {
            return response()->json(["massage"=>"Failed to Store"],400);
        }
    }

    public function SolarPrice_Advertise()
    {
        $data['solar_price'] = Solar_Price::all();
        $data['advertise'] = Advertise::all();
        return response()->json($data,200);
    }

    public function showNotification()
    {
        $id = Auth::User()->id;
        $notifications = Notification::getAllNotifications($id);
        return response()->json($notifications,200);
    }

    public function addAdvertise(Request $request)
    {
        $fetchedData = $request->all();

        $this->validate($request,[
            'photo' => 'required',
        ]);

        $url = User::fileUpload($request);
        $isEdited = Advertise::where('id',1)->update([
            'photo' => $url
        ]);

        if($isEdited)
        {
            return response()->json(["massage"=>"Store Successfully"],200);
        }
        else
        {
            return response()->json(["massage"=>"Failed to Store"],400);
        }
    }

    public function updateSolar(Request $request)
    {
        $fetchedData = $request->all();

        $this->validate($request,[
            'oli82price' => 'required',
            'oli92price' => 'required',
            'oli95price' => 'required',
            'solarprice' => 'required',
            'gasprice'   => 'required',
        ]);

        $isEdited = Solar_Price::where('id',1)->update([
            'oli82price' => $fetchedData['oli82price'],
            'oli92price' => $fetchedData['oli92price'],
            'oli95price' => $fetchedData['oli95price'],
            'solarprice' => $fetchedData['solarprice'],
            'gasprice'   => $fetchedData['gasprice'],
        ]);

        if($isEdited)
        {
            return response()->json(["massage"=>"Store Successfully"],200);
        }
        else
        {
            return response()->json(["massage"=>"Failed to Store"],400);
        }
    }
}
