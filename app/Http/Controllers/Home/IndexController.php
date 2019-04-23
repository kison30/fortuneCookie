<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Good;
use App\Http\Model\GoodsSubjectclass;
use App\Http\Model\Member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    public function index(){

        $is_index = 'yes';

        $AllMenu = GoodsSubjectclass::where('f_id',1)->get();

        $AllGoods = $AllMenu;

        foreach ($AllGoods as $value) {
            $value->goods = Good::where([
                ['cid', '=', $value->id],
                ['is_up', '=', 1],
            ])->get();
        }

        //购物车
        if (Auth::check()){
            $allconfigArr = getAllconfigs();

            $collectionOnly = $allconfigArr['collectionOnly'];
            $deliveryOnly = $allconfigArr['deliveryOnly'];

            if ($collectionOnly==1){
                Member::where('id',Auth::user()->id)->update(['deli_method'=>'Collection']);
            }elseif ($deliveryOnly==1){
                Member::where('id',Auth::user()->id)->update(['deli_method'=>'Delivery']);
            }

            $cartInfoArr = array();
            if (Auth::user()->cartInfo != '' || Auth::user()->cartInfo != null){
                $cartInfoArr = unserialize(stripslashes(Auth::user()->cartInfo));
            }

            if (isset($cartInfoArr) && count($cartInfoArr)>0) {
                return view('home.index',compact('AllMenu','AllGoods','cartInfoArr','is_index'));
            }else{
                return view('home.index',compact('AllMenu','AllGoods','is_index'));
            }

        }else{
            return view('home.index',compact('AllMenu','AllGoods','is_index'));
        }



    }
}
