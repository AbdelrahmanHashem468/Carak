<?php

namespace App\Model\Service;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Notification extends Model
{
    protected $guarded = [];

    public static function getAllNotifications($id)
    {
        $notSeen=0;
        $notifications = User::find($id)->notification->sortBy('seen');
        foreach($notifications as $notification)
        {
            if($notification['seen']==0)
                $notSeen++;
        }
        $notifications['notseen']=$notSeen;
        Notification::where('user_id',$id)->update(['seen'=>1]);
        return $notifications;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
