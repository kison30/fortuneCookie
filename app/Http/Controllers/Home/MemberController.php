<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Member;
use App\Http\Model\Order;
use App\Http\Requests\MemberLoginRegquest;
use App\Http\Requests\MemberProfileRequst;
use App\Http\Requests\MemberRegisterRegquest;
use App\Http\Requests\MemberUpPwdRequest;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function retry_paypal($id){

        $allconfigArr = getAllconfigs();

        $one = Order::find($id);

        //成功回调地址
        $returnUrl = 'http://'.$allconfigArr['websiteurl'].'/returnUrl/'.$one->id;
        $query = array();
        $query['cmd'] = '_xclick';
        $query['business'] = $allconfigArr['paypalaccount'];
        $query['currency_code'] = 'GBP';
        $query['item_name'] = $one->ordernum;
        $query['amount'] = $one->price;
        $query['quantity'] = '1';
        $query['custom'] = $one->ordernum;
        $query['return'] = $returnUrl;
        $query['cancel_return'] = 'http://'.$allconfigArr['websiteurl'].'/cancel_return/'.$one->id;
        $query['notify_url'] = 'http://'.$allconfigArr['websiteurl'].'/paysuc';
        // Prepare query string
        $query_string = http_build_query($query);

        return redirect('https://www.paypal.com/uk/cgi-bin/webscr?' . $query_string);
    }

    public function myorders()
    {

        $all = Order::orderBy('id','desc')->paginate(15);

        return view('home.member.myorders',compact('all'));

    }

    public function vieworder($id)
    {

        $one = Order::find($id)->toArray();


        $one['goodsArray'] = unserialize(stripslashes($one['goods']));


        $one['total'] = $one['price'];
        unset($one['id']);
        unset($one['shop']);
        unset($one['shop_printer_id']);
        unset($one['goods']);
        unset($one['flag']);


        return view('home.member.oneorder',compact('one'));

    }


    public function profile()
    {
        return view('home.member.profile');

    }

    public function profile_do(MemberProfileRequst $request)
    {

            $input = $request->except('_token');

            $member_id = Auth::user()->id;


            $result = Member::where('id',$member_id)->update($input);
            if($result){
                return redirect('profile')->with('message', 'Updated successfully');
            }else{
                return back()->with(['errors'=>'Updated failed!']);
            }




        return view('home.member.profile');

    }
    //修改密码
    public function password()
    {
        $navID = 'password';
        return view('home.member.password',compact('navID'));

    }
    /**
     * 执行律师修改密码
     */
    public function password_do(MemberUpPwdRequest $request)
    {

        $member_id = Auth::user()->id;

        $input = $request->all();
        $new_data = [];
        $new_data['password'] = \Hash::make($input['password']);

        //验证旧密码
        if (Auth::attempt([
            'id'       =>$member_id,
            'password' =>$request->get('old_password')
        ])) {
            //如果旧密码验证通过
            $res = Member::where('id',$member_id)->update($new_data);
            if($res){
                Auth::logout();
                return redirect('login')->with('message', 'Updated successfully');
            }else{
                return back()->with(['errors'=>'Username or password is incorrect']);
            }
        }else{
            return back()->with(['errors'=>'Old password is incorrect']);
        }

    }


    public function register( )
    {
        return view('home.member.register');
    }

    public function register_do(MemberRegisterRegquest $request)
    {
        $input = $request->except('_token');
        $input['created_at'] = Carbon::now();

        $result = Member::create($input);
        if($result){
            return redirect('login')->with('success', 'Successful Registration !');
        }else{
            return back()->with(['errors'=>'Register failed !']);
        }

    }

    public function login()
    {
        return view('home.member.login');

    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
    /**
     * 登录验证
     */
    public function login_do(MemberLoginRegquest $request)
    {


        if (Auth::attempt([
            'username'=>$request->get('username'),
            'password'=>$request->get('password')
        ])) {

            return redirect('/');
        }

        return back()->with(['errors'=>'Login failed !']);

    }




}
