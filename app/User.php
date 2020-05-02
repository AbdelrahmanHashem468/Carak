<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Model\Maintenance\Maintenance_Center;
use Illuminate\Notifications\Notifiable;
use App\Model\Service\Notification;
use Laravel\Passport\HasApiTokens;
use JD\Cloudder\Facades\Cloudder;
use App\Model\Car\Car_For_Sell;
use App\Model\Car\Spare_part;
use App\Model\Service\Offer;
use Illuminate\Http\Request;
use App\Model\Group\Reply;
use App\Model\Group\Post;
use Auth;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','phonenumber', 'photo','role','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getAllUsers()
    {
        return User::all();
    }

    public static function getInstance()
    {
        $users = User::getAllUsers();
        if(sizeof($users)>0)
            return $users[rand(0,sizeof($users)-1)]['id'];
    }

    public static function getAllUserData()
    {
        $data=[];
        $id = Auth::User()->id;
        $data['spare_parts'] = Auth::User()->spare_part;
        $data['car_for_sell'] = Auth::User()->Car_For_Sell;
        $data['offer'] = Auth::User()->offer;
        $data['center'] = Auth::User()->maintenance_center;
        return $data;
    }



    public static function fileUpload(Request $request)
    {
        $request->validate([
            'photo'=>'required|mimes:jpeg,bmp,jpg,png',
        ]);
        $image = $request->file('photo');
        $name = $request->file('photo')->getClientOriginalName();
        $image_name = $request->file('photo')->getRealPath();;
        Cloudder::upload($image_name, null);
        list($width, $height) = getimagesize($image_name);
        $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);
        $image->move(public_path("/images"), $name);
        return $image_url;
    }

/*
    public static function fileUpload(Request $request) 
    {

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            return $name;
        }
    }
*/

    public function spare_part()
    {
        return $this->hasMany(Spare_part::class);
    }


    public function car_for_sell()
    {
        return $this->hasMany(Car_For_Sell::class);
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function reply()
    {
        return $this->hasMany(Reply::class);
    }

    public function maintenance_center()
    {
        return $this->hasMany(Maintenance_Center::class);
    }

    public function offer()
    {
        return $this->hasMany(Offer::class);
    }

    public function notification()
    {
        return $this->hasMany(Notification::class);
    }
}
