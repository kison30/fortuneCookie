<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $table = "goods";
    protected $guarded = [];
    public $timestamps = false;
}
