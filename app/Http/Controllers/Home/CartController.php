<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Good;
use App\Http\Model\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function checkout(){


        //判断购物车是否为空，防止用户直接从地址栏输入而进入，而不是从上一页按钮点进来
        $cartInfoArr = array();
        if (Auth::user()->cartInfo != '' || Auth::user()->cartInfo != null){
            $cartInfoArr = unserialize(stripslashes(Auth::user()->cartInfo));

            $allconfigArr = getAllconfigs();

            $today = Carbon::today()->toDateString();
            $open_time = $today.' '.$allconfigArr['openingstart'];
            $closed_time = $today.' '.$allconfigArr['openingend'];



            $open_time_full = Carbon::parse($open_time);
            $closed_time_full = Carbon::parse($closed_time);


            $weekMap = [
                0 => 'Sunday',
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
            ];


            $alltimeArray = array();

            $now = Carbon::now();

            //less than小于
            if ($now->lt($open_time_full)){

                while (($open_time_full->addMinute($allconfigArr['time_interval']))->lt($closed_time_full)){

                    $weekday = $weekMap[$open_time_full->dayOfWeek];
                    $alltimeArray[] = $weekday.' '.$open_time_full->copy();
                }

            }else{

                //额外增加的送餐时间
                $now = $now->addMinute($allconfigArr['devilery_time']);

                while (($now->addMinute($allconfigArr['time_interval']))->lt($closed_time_full)){

                    $weekday = $weekMap[$open_time_full->dayOfWeek];
                    $alltimeArray[] = $weekday.' '.$now->copy();
                }
            }

            $tomorrow = Carbon::tomorrow()->toDateString();
            $tomorrow_open_time = $tomorrow.' '.$allconfigArr['openingstart'];
            $tomorrow_closed_time = $tomorrow.' '.$allconfigArr['openingend'];
            $tomorrow_open_time_full = Carbon::parse($tomorrow_open_time);
            $tomorrow_closed_time_full = Carbon::parse($tomorrow_closed_time);
            while (($tomorrow_open_time_full->addMinute(5))->lt($tomorrow_closed_time_full)){

                $tomorrow_weekday = $weekMap[$tomorrow_open_time_full->dayOfWeek];
                $alltimeArray[] = $tomorrow_weekday.' '.$tomorrow_open_time_full->copy();
            }

            return view('home.checkout',compact('cartInfoArr','alltimeArray'));
        }else{
            return redirect('/');
        }


    }


    /**修改会员delivery method**/
    public function changeDeli(Request $request){

        return Member::where('id',Auth::user()->id)->update(['deli_method'=>$request->get('deli_method')]);
    }


    public function showCart()
    {
        $html = '';

        $cartInfoArr = array();
        if (Auth::user()->cartInfo != '' || Auth::user()->cartInfo != null){
            $cartInfoArr = unserialize(stripslashes(Auth::user()->cartInfo));
        }


        if (isset($cartInfoArr) && count($cartInfoArr)>0) {

            $html .= '<ul class="list-group">
                                <li class="list-group-item" style="padding: 0px;">
                                    <div  style="overflow-y: auto; height:180px;">
                                    <div class="table-responsive">
                                        <table class="table" style="border: 0px;">
                                            <tbody>';

            $total = 0.0;

            $cartInfoArr = array_reverse($cartInfoArr);
            foreach ($cartInfoArr as $key=>$value) {
                $total += $value['num']*$value['price'];

                $html .= '<tr>
                            <td>'.$value['num'].' X '.$value['name'].'</td>
                            
                            <td><span class="float-right">£'.($value['num'])*($value['price']).'</span></td>
                            <td>
                                <a  class="btn btn-danger btn-sm delCart" id="'.$value["id"].'"><i class="fa fa-minus" aria-hidden="true"></i></a>
                            </td>
                            </tr>';

            }


            $html .= '</tbody></table></div></div>

                                </li>
                            </ul>
                            <ul class="list-group" style="margin-bottom: 0px;border: 0px;">
                                <li class="list-group-item" style="border: 0px;">
                                    <span class="float-right">Total: £<b id="totalprice">'.$total.'</b></span>
                                </li>
                            </ul>
                        </div>';

            $html .= '<div class="input-group" style="margin-top: 10px;">

                                <div class="input-group-addon" style="padding: 0px;width: 100%">';


            if (Auth::user()->deli_method == 'Collection'){
                $html .= '<a class="btn btn-success btn-block" href="'.url("checkout").'" style="border-radius: 0px">Checkout</a>';
            }else{

                $allconfigArr = getAllconfigs();

                if ($total>=$allconfigArr['minprice']){
                    $html .= '<a class="btn btn-success btn-block" href="'.url("checkout").'" style="border-radius: 0px">Checkout</a>';
                }else{
                    $html .= '<button type="button" class="btn  btn-block btn-success" disabled>Checkout</button>';
                }

            }



            $html .= '</div>

                            </div>';






        }else{
            $html.= '<ul class="list-group">
                                <li class="list-group-item" style="padding: 0px;">
                                    <div  style="overflow-y: auto; height:180px;">
                                        <div class="table-responsive">
                                            <table class="table" style="border: 0px;">
                                                <tbody>
                                                <tr>
                                                    <td>There are no items in your basket</td>
                                                </tr>
    
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>

                                </li>
                            </ul>
                            <ul class="list-group" style="margin-bottom: 0px;border: 0px;">
                                <li class="list-group-item" style="border: 0px;">
                                    <span class="float-right">Total: £<b id="totalprice">0</b></span>
                                </li>
                            </ul>

                            <div class="input-group" style="margin-top: 10px;">

                                <div class="input-group-addon" style="padding: 0px;width: 100%">
                                    <button type="button" class="btn  btn-block btn-success" disabled>Checkout</button>
                                </div>

                            </div>';
        }
        echo $html;

    }
    public function addCart(Request $request){


        $id = $request->get('id');

        $onegood = Good::find($id);

        $cid = $onegood->cid;
        $name = $onegood->name;
        $name_cn = $onegood->name_cn;
        $sn = $onegood->sn;
        $price = $onegood->price;
        $description = $onegood->description;

        $cartInfoArr = array();
        if (Auth::user()->cartInfo != '' || Auth::user()->cartInfo != null){
            $cartInfoArr = unserialize(stripslashes(Auth::user()->cartInfo));
        }


        if (isset($cartInfoArr[$id])){

            $cartArr=$cartInfoArr[$id];
            $cartArr['num']=$cartArr['num']+1;
            $cartInfoArr[$id] = $cartArr;
            return Member::where("id",Auth::user()->id)->update(["cartInfo"=>serialize($cartInfoArr)]);


        }else{

            $cartInfoArr[$id] = array(
                'id'=>$id,
                'cid'=>$cid,
                'name'=>$name,
                'name_cn'=>$name_cn,
                'sn'=>$sn,
                'price'=>$price,
                'description'=>$description,
                'num'=>1
            );

            return Member::where("id",Auth::user()->id)->update(["cartInfo"=>serialize($cartInfoArr)]);

        }
    }
    public function delCart(Request $request){
        $id = $request->get('id');

        $cartInfoArr = array();
        if (Auth::user()->cartInfo != '' || Auth::user()->cartInfo != null){
            $cartInfoArr = unserialize(stripslashes(Auth::user()->cartInfo));

            if (isset($cartInfoArr[$id])){

                $cartArr=$cartInfoArr[$id];
                $cartArr['num']=$cartArr['num']-1;

                if ($cartArr['num']!=0){
                    $cartInfoArr[$id] = $cartArr;
                    return Member::where("id",Auth::user()->id)->update(["cartInfo"=>serialize($cartInfoArr)]);
                }else{

                    unset($cartInfoArr[$id]);
                    //购物车为空，千万注意，一定要直接清空，不能把空数组编码
                    if (count($cartInfoArr) ==0){
                        return Member::where("id",Auth::user()->id)->update(["cartInfo"=>'']);
                    }else{
                        return Member::where("id",Auth::user()->id)->update(["cartInfo"=>serialize($cartInfoArr)]);
                    }


                }
            }

        }

    }
    public function clearCart(){
        return Member::where("id",Auth::user()->id)->update(["cartInfo"=>""]);
    }

}
