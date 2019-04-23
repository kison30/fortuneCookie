<?php

namespace App\Http\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    protected $table='admins';
    protected $guarded = ['password_confirmation'];
    public $timestamps = false;

    public function setPasswordAttribute($value){

        //Auth里面都是用Hash而且非Crypt加密的
        if( \Hash::needsRehash($value) ) {
            $value = \Hash::make($value);
        }
        $this->attributes['password'] = $value;
    }
}
