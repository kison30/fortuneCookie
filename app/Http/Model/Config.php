<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = "configs";
    protected $guarded = [];
    public $timestamps = false;
}
