<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Laravel\Passport\HasApiTokens;
use App\Model\Car\Spare_part;
use App\Model\Car\Car_For_Sell;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','phonenumber', 'password',
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

    public function spare_part()
    {
        return $this->hasMany(Spare_part::class);
    }

    
    public function car_for_sell()
    {
        return $this->hasMany(Car_For_Sell::class);
    }
}
