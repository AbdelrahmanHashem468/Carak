<?php

namespace App\Model\Service;

use Illuminate\Database\Eloquent\Model;
use App\Model\Service\Photo;
use App\User;

class Offer extends Model
{
    protected $guarded = [];

    public static function getAllOffers()
    {
        $offers = Offer::where('status','2')
        ->orderBy('created_at','desc')->paginate(10);
        for($i=0;$i<sizeof($offers);$i++)
        {
            $offers[$i]['user_name'] = $offers[$i]->user->name;
            $offers[$i]['user_photo'] = $offers[$i]->user->photo;
            $offers[$i]['user_phonenumber'] = $offers[$i]->user->phonenumber;
            unset( $offers[$i]['user']);
            $offers[$i]['photos'] =
            Photo::select('name')->where('type',3)
            ->where('object_id',$offers[$i]['id'])->get();
        }
        return $offers;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
