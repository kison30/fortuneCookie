<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Member;
use App\Http\Model\Order;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //打印机每当打印完成回调函数，返回到此地址
    public function callback(Request $request) {

                //在打印的时候这儿传的是order id非number， 这儿一定要注册
                $ordernumber = $request->ordernumber;
                $rest_printer_id = $request->restid;
                //更新订单状态，设置为已打印

                Order::where('id',$ordernumber)->update(['flag'=>1,'status'=>'received']);

                $myfile = "public/download/".$rest_printer_id.".txt";


                if (unlink($myfile)) {
                    //如果删除txt成功，那么查询位打印订单，注意这儿需要加上rest打印机的 id知道哪一家店的未打印订单
                    //取出未打印的其中一个
                    $unprintOrders = Order::where([
                        ['flag', '=', '0'],
                        ['paymentMethod', '=', 'Cash']
                    ])->orWhere([
                        ['flag', '=', '0'],
                        ['paymentMethod', '=', 'Paypal'],
                        ['order_pay', '=', 'Paid']
                    ])->first();

                    if ($unprintOrders) {
                        //每次只打印第一个
                        if ($this->printorder($unprintOrders)) return 1;

                    }

                }


    }

    //支付之后通知paypal post 并打印订单
    public function paysuc(){
        $ordernum = $_POST['custom'];

        if (Order::where('ordernum',$ordernum)->update(['order_pay'=>'Paid'])){

            $oneorder = Order::where('ordernum',$ordernum)->first();


            if ($this->printorder($oneorder)) return true;

        }


    }

    //支付成功后打印
    public function printorder($One){
            $allconfigArr = getAllconfigs();
            $shop_printer_id=$allconfigArr['printerID'];
            $websiteurl=$allconfigArr['websiteurl'];
            $tel=$allconfigArr['tel'];

            $myfile = "public/download/".$shop_printer_id.".txt";


            $id= $One->id;
            $ordernum= $One->ordernum;
            $fullName= $One->firstname.' '.$One->lastname;
            $mobile = $One->mobile;
            $address = $One->address;

            $code = 'Postcode:  '.$One->postcode;
            $price = $One->price;
            $specialrequests = $One->specialrequests;
            $goods = $One->goods;

            $takeawayType = $One->takeawayType;
            $paymentMethod = $One->paymentMethod;
            $time = $One->preorder_datetime;
            $deliveryfee = $One->delivery_fee;


            $goods = unserialize(htmlspecialchars_decode($goods));

            if (is_array($goods)) {
                foreach ($goods as $_key=>$_value) {
                    $goods[$_key] = $_value;
                }
            }

            $content="";

            foreach ($goods as $key => $value) {
                $subtotal = $value['num']*$value['price'];
                $content .= '<l>'.$value['num'].' X '.$value['name_cn'].'<right>'.$subtotal.'<br>'.$value['sn'].$value['name'].'<br>';
            }

            if ($takeawayType == 'Delivery'){

                if ($specialrequests !=''){
                    $str = '#'.$shop_printer_id.'*'.$id.'*<dot><br><l>'.$takeawayType.'<br><dot><br>Order No.:'.$ordernum.'<br><l>Datetime:<br>'.$time.'<br>'.$fullName.'<br>'.$address.'<br>'.$code.'<br>Mob: '.$mobile.'<br><dot><br>'.$content.'<br><dot><br>Delivery fee: '.$deliveryfee.'<br>Total:<right>GBP '.$price.'<br>Pay by:<right>'.$paymentMethod.'<br><dot><br><center>Tel:'.$tel.'<br><center>'.$websiteurl.'<br><dot><br><l>Comments<br>'.$specialrequests.'<br><line><br><center>Thank       You!
		<br>#';
                }else{
                    $str = '#'.$shop_printer_id.'*'.$id.'*<dot><br><l>'.$takeawayType.'<br><dot><br>Order No.:'.$ordernum.'<br><l>Datetime:<br>'.$time.'<br>'.$fullName.'<br>'.$address.'<br>'.$code.'<br>Mob: '.$mobile.'<br><dot><br>'.$content.'<br><dot><br>Delivery fee: '.$deliveryfee.'<br>Total:<right>GBP '.$price.'<br>Pay by:<right>'.$paymentMethod.'<br><dot><br><center>Tel:'.$tel.'<br><center>'.$websiteurl.'<br><line><br><center>Thank       You!
		<br>#';
                }



            }else{

                if ($specialrequests !=''){
                    $str = '#'.$shop_printer_id.'*'.$id.'*<dot><br><l>'.$takeawayType.'<br><dot><br>Order No.:'.$ordernum.'<br>Datetime:<br>'.$time.'<br>'.$fullName.'<br>Mob: '.$mobile.'<br><dot><br>'.$content.'<br><dot><br>Total:<right>GBP '.$price.'<br>Pay by:<right>'.$paymentMethod.'<br><dot><br><center>Tel:'.$tel.'<br><center>'.$websiteurl.'<br><dot><br><l>Comments<br>'.$specialrequests.'<br><line><br><center>Thank       You!
		<br>#';
                }else{
                    $str = '#'.$shop_printer_id.'*'.$id.'*<dot><br><l>'.$takeawayType.'<br><dot><br>Order No.:'.$ordernum.'<br>Datetime:<br>'.$time.'<br>'.$fullName.'<br>Mob: '.$mobile.'<br><dot><br>'.$content.'<br><dot><br>Total:<right>GBP '.$price.'<br>Pay by:<right>'.$paymentMethod.'<br><dot><br><center>Tel:'.$tel.'<br><center>'.$websiteurl.'<br><line><br><center>Thank       You!
		<br>#';
                }



            }


            $file_pointer = fopen($myfile,"w");
            fwrite($file_pointer,$str);
            fclose($file_pointer);

            return true;

    }

    //支付成功后跳转的页面
    public function returnUrl($id){

        $oneorder = Order::find($id);
        return view('home.returnUrl',compact('oneorder'));

    }
    //支付失败跳转的页面
    public function cancel_return($id){
        $oneorder = Order::find($id);
        return view('home.cancel_return',compact('oneorder'));
    }





    public function deliveryFeeAndCardFee(Request $request){

        $allconfigArr = getAllconfigs();

        $extratotal = 0;

        //Delivery送餐
        if (Auth::user()->deli_method == 'Delivery'){

            $delivery_fee = 0;
            $shop_postcode = str_replace(' ','',$allconfigArr['postcode']);
            $client_postcode = str_replace(' ','',$request->postcode);
            $distance = $this->distance($shop_postcode,$client_postcode);

            if ($distance<0){
                $delivery_fee =0;
                if ($request->paymentMethod == 'Paypal'){
                    $extratotal = $allconfigArr['card_fee'] + $delivery_fee;

                    $arr = array("extratotal"=>$extratotal,"delivery_fee"=>$delivery_fee,"statuscode"=>"invalidpostcode","info"=>"Invalid postcode ！Please input valid postcode !");
                    print_r(json_encode($arr));

                }else{
                    $extratotal = $delivery_fee;
                    $arr = array("extratotal"=>$extratotal,"delivery_fee"=>$delivery_fee,"statuscode"=>"invalidpostcode","info"=>"Invalid postcode ！Please input valid postcode !");
                    print_r(json_encode($arr));
                }

            }elseif ($distance>=0 && $distance<3){
                $delivery_fee =1.5;
                if ($request->paymentMethod == 'Paypal'){
                    $extratotal = $allconfigArr['card_fee'] + $delivery_fee;

                    $arr = array("extratotal"=>$extratotal,"delivery_fee"=>$delivery_fee,"statuscode"=>"freedelievery","info"=>"Congratulations, we can deliver the order to you width delivery fee £$delivery_fee");
                    print_r(json_encode($arr));

                }else{
                    $extratotal = $delivery_fee;
                    $arr = array("extratotal"=>$extratotal,"delivery_fee"=>$delivery_fee,"statuscode"=>"freedelievery","info"=>"Congratulations, we can deliver the order to you width delivery fee £$delivery_fee");
                    print_r(json_encode($arr));
                }


            }elseif ($distance>3 && $distance<=$allconfigArr['maxdelivery']){
                $delivery_fee = 2.5;

                if ($request->paymentMethod == 'Paypal'){
                    $extratotal = $allconfigArr['card_fee'] + $delivery_fee;

                    $arr = array("extratotal"=>$extratotal,"delivery_fee"=>$delivery_fee,"statuscode"=>"delievery","info"=>"Congratulations, we can deliver the order to you width delivery fee £$delivery_fee");
                    print_r(json_encode($arr));

                }else{
                    $extratotal = $delivery_fee;
                    $arr = array("extratotal"=>$extratotal,"delivery_fee"=>$delivery_fee,"statuscode"=>"delievery","info"=>"Congratulations, we can deliver the order to you width delivery fee £$delivery_fee");
                    print_r(json_encode($arr));
                }

            }else{
                $delivery_fee = 0;
                $maxdis = $allconfigArr['maxdelivery'];
                if ($request->paymentMethod == 'Paypal'){
                    $extratotal = $allconfigArr['card_fee'] + $delivery_fee;

                    $arr = array("extratotal"=>$extratotal,"delivery_fee"=>$delivery_fee,"statuscode"=>"outofdelievery","info"=>"Sorry, our maximum distance is $maxdis miles, your location is too far from our store, we can not deliver the order to you.");
                    print_r(json_encode($arr));

                }else{
                    $extratotal = $delivery_fee;
                    $arr = array("extratotal"=>$extratotal,"delivery_fee"=>$delivery_fee,"statuscode"=>"outofdelievery","info"=>"Sorry, our maximum distance is $maxdis miles, your location is too far from our store, we can not deliver the order to you.");
                    print_r(json_encode($arr));
                }
            }



         //去店取
        }else{

            //Paypal
            if ($request->paymentMethod == 'Paypal'){

                $extratotal = $allconfigArr['card_fee'];
                $arr = array("extratotal"=>$extratotal,"delivery_fee"=>0,"statuscode"=>"collection","info"=>"");
                print_r(json_encode($arr));

                //Cash
            }else{
                $arr = array("extratotal"=>0,"delivery_fee"=>0,"statuscode"=>"collection","info"=>"");
                print_r(json_encode($arr));
            }
        }


    }

    public function distance($post1,$post2) {

        $postcode1=($post1);
        $postcode2=($post2);

        $url = "http://maps.googleapis.com/maps/api/distancematrix/json?origins=$postcode2&destinations=$postcode1&mode=driving&language=en-EN&sensor=false";

        $data = file_get_contents($url);
        $result = json_decode($data, true);

        foreach($result['rows'] as $distance) {

            if ($distance['elements'][0]['status'] == 'NOT_FOUND') {
                return -1;
            }else{
                return  $distance['elements'][0]['distance']['value']*0.001*0.621371;
            }

        }
    }



    public function order(OrderRequest $request){
        $paymentMethod= $request->paymentMethod;

        $input = $request->except('_token');
        $input['username'] = Auth::user()->username;
        $input['ordernum'] = date('YmdHis'.mt_rand(1,9999));
        $input['goods'] = Auth::user()->cartInfo;
        $input['created_at'] = Carbon::now();
        $input['takeawayType'] = Auth::user()->deli_method;

        $res = Order::create($input);

        if ($res){

            Member::where('id',Auth::user()->id)->update(['cartInfo'=>'']);

            if ($paymentMethod=='Cash'){


                //成功回调地址
                if ($this->printorder($res)) return redirect('returnUrl/'.$res->id);


            }else{
                //跳转到Paypal支付页面
                $allconfigArr = getAllconfigs();
                //成功回调地址
                $returnUrl = 'http://'.$allconfigArr['websiteurl'].'/returnUrl/'.$res->id;
                $query = array();
                $query['cmd'] = '_xclick';
                $query['business'] = $allconfigArr['paypalaccount'];
                $query['currency_code'] = 'GBP';
                $query['item_name'] = $input['ordernum'];
                $query['amount'] = $request->get('price');
                $query['quantity'] = '1';
                $query['custom'] = $input['ordernum'];
                $query['return'] = $returnUrl;
                $query['cancel_return'] = 'http://'.$allconfigArr['websiteurl'].'/cancel_return/'.$res->id;
                $query['notify_url'] = 'http://'.$allconfigArr['websiteurl'].'/paysuc';
                // Prepare query string
                $query_string = http_build_query($query);

                return redirect('https://www.paypal.com/uk/cgi-bin/webscr?' . $query_string);
            }






        }else{
            return back()->with(['errors'=>'Order failed !']);
        }
    }
}
