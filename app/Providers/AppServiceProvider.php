<?php

namespace App\Providers;

use App\Http\Model\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */


    public function boot()
    {
        $all = Config::all();

        $allconfigArr = array();

        foreach ($all as  $val){
            if ($val->name =='openingstart' || $val->name =='openingend'){
                $temp = substr($val->values,0,5);
                View::share('gl_'.$val->name,$temp);
            }else{
                View::share('gl_'.$val->name,$val->values);
            }

            $allconfigArr["$val->name"]=$val->values;
        }

        $today = Carbon::today()->toDateString();

        $open_time = $today.' '.$allconfigArr['openingstart'];
        $closed_time = $today.' '.$allconfigArr['openingend'];
        $morning_time = $today.' '.$allconfigArr['morning_time'];

        $open_time_full = Carbon::parse($open_time);
        $closed_time_full = Carbon::parse($closed_time);
        $morning_time_full = Carbon::parse($morning_time);

        $is_open = 'yes';
        $now = Carbon::now();

        if ($closed_time_full>$morning_time_full){
            if ($now>=$open_time_full && $now<=$closed_time_full){
                $is_open = 'yes';
            }else{
                $is_open = 'no';
            }
        }else{
            if ($now>=$open_time_full || $now<=$morning_time_full){
                $is_open = 'yes';
            }else{
                $is_open = 'no';
            }

        }

        View::share('gl_is_open',$is_open);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
