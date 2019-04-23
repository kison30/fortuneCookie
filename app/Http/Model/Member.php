<?php

namespace App\Http\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Member extends Authenticatable
{
    use Notifiable;

    protected $table = "members";
    protected $guarded = ['password_confirmation','agree'];
    public $timestamps = false;

    public function setPasswordAttribute($value){


        //Auth里面都是用Hash而且非Crypt加密的
        if( \Hash::needsRehash($value) ) {
            $value = \Hash::make($value);
        }
        $this->attributes['password'] = $value;
    }
}
