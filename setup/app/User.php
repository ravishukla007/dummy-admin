<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'age_group', 'otp', 'status', 'mobile_number'
    ];

    protected $attributes = [
        'status' => 1
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

    function getNameAttribute($name) {
        return ucfirst($name);
    }

    function getMobileNumberAttribute($number) {
        if(!$number) { return 'N/A'; }
        return $number;
    }

    function getStatusAttribute($status) {
        if($status == 1) { return 'Active'; }
        if($status == 2) { return 'Inactive';}
        return 'Pending for Approval';
    }

    function getAgeGroupAttribute($status) {
        if($status == '6-to-7') { return '6 to 7'; }
        if($status == '8-to-13') { return '8 to 13';}
        return '3 to 5';
    }
    function getAvatarAttribute($image) {
      if($image) {
          return asset("asset/profile/$image");
      }
    }
}
