@extends('home.layout.layout')

@section('content')

    <link rel="stylesheet" type="text/css" href="{{url('resources/views/home/style/checkout.css')}}" />
    <div class="container-fluid" style="margin-top: 30px;">
        <form id="formID" method="post"  action="{{url('order')}}">
            {{csrf_field()}}

            <div class="row">

                <!-- 左侧订单列表 -->

                <div class="col-md-4">
                    <ul class="list-group"  style="border: 2px solid #afd136;margin-bottom: 15px;">

                        <li class="list-group-item" style="border: 0px;">Your Order for <b>{{Auth::user()->deli_method}}</b></li>

                        <li class="list-group-item"  style="border: 0px;">
                            <div  style="min-height:80px;">

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody style="width: 100%;">
                                        <?php $total = 0; ?>
                                        @if(Auth::check())

                                            @if(isset($cartInfoArr) && count($cartInfoArr)>0)


                                                @foreach($cartInfoArr as $val)
                                                    <?php
                                                    $total = $total + $val['num']*$val['price'];
                                                    ?>

                                                    <tr>
                                                        <td>{{$val['num']}} X {{$val['name']}}</td>
                                                        <td><span class="float-right">£{{$val['num']*$val['price']}}</span></td>

                                                    </tr>
                                                @endforeach


                                            @else
                                                <tr>
                                                    <td>There are no items in your basket</td>
                                                </tr>

                                            @endif

                                        @else

                                            <tr>
                                                <td>There are no items in your basket</td>
                                            </tr>

                                        @endif


                                        </tbody>
                                    </table>
                                </div>


                            </div>

                        </li>
                        <li class="list-group-item" style="border: 0px;">
                            <span class="float-right">Subtotal: £{{$total}}</span>
                        </li>
                        <li class="list-group-item" style="border: 0px;">
                            <span class="float-right">Delivery fee: £<span id="delivery_fee_div">0</span></span>
                        </li>
                        <li class="list-group-item" style="border: 0px;">
                            <span class="float-right">Total: £<b id="total_price_div">{{$total+$gl_card_fee}}</b></span>
                        </li>
                    </ul>
                    <a href="{{url('/')}}" class="btn btn-success btn-block" style="margin-bottom: 15px;" role="button" aria-pressed="true">Go back and edit your order</a>
                    <div class="form-group">
                        <label for="exampleTextarea"><h5>Any special requests or comments?</h5></label>
                        <textarea class="form-control" name="specialrequests" rows="3"></textarea>
                        <small><p class="text-justify">Please use this box to tell us if you have any other requirements or if you want to leave a note about delivery (if applicable). Note that some requests may not be possible or may incur a fee.</p></small>
                    </div>

                </div>

                <!--中间-->
                <div class="col-md-5">

                    @if(count($errors)>0)

                        <ul class="list-group">

                            @if(is_object($errors))
                                @foreach($errors->all() as $error)
                                    <li class="list-group-item list-group-item-danger">{{$error}}</li>
                                @endforeach
                            @else
                                <li class="list-group-item list-group-item-danger">{{$errors}}</li>
                            @endif

                        </ul>

                    @endif

                    <div style="border: 2px solid #afd136;padding: 15px;margin-bottom: 15px;">
                        <h5>Confirm your
                            @if(Auth::user()->deli_method == 'Delivery')
                                Delivery
                            @else
                                Collection
                            @endif
                            details
                        </h5>
                        <br>
                        <div class="form-group">
                            <label for="firstName">First name</label>
                            <input type="text"  id="firstname" name="firstname" @if(session()->has('firstname')) value="{{session('firstname')}}" @else value="{{Auth::user()->firstname}}" @endif class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="lastName">Last name</label>
                            <input type="text"  id="lastname" name="lastname" class="form-control" @if(session()->has('lastname')) value="{{session('lastname')}}" @else value="{{Auth::user()->lastname}}" @endif >
                        </div>

                        <div class="form-group">
                            <label for="mobile">Mobile number</label>
                            <input type="text" id="mobile" name="mobile"  class="form-control" @if(session()->has('mobile')) value="{{session('mobile')}}" @else  value="{{Auth::user()->mobile}}" @endif aria-describedby="mobileHelp">
                            <small id="mobileHelp" class="form-text text-muted">Please input an valid mobile number for notifaction only.<br>(eg:If merchant canncel it.)</small>
                        </div>
                        @if(Auth::user()->deli_method == 'Delivery')

                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" class="form-control"  @if(session()->has('address')) value="{{session('address')}}" @else value="{{Auth::user()->address}}" @endif >
                            </div>


                            <div class="form-group">
                                <label for="postcode">Postcode</label>

                                <div class="input-group" style="width: 300px;">
                                    <input id="postcodeInput" type="text" name="postcode" class="form-control"  @if(session()->has('postcode')) value="{{session('postcode')}}" @else  value="{{Auth::user()->postcode}}"  @endif >
                                    <span class="input-group-btn">
                                        <button id="postcodechecker" class="btn btn-danger" type="button">Check Postcode</button>
                                    </span>
                                </div>
                                <small class="form-text text-muted0" style="color: red">*Please press 'Check Postcode' button to check whether your location is in our delivery zone.</small>
                            </div>

                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" class="form-control"  @if(session()->has('city')) value="{{session('city')}}" @else  value="{{Auth::user()->city}}"  @endif>
                            </div>

                        @endif


                        <div class="form-group">
                            <label for="city">Country</label>
                            <input type="text" id="country" name="country" class="form-control" readonly value="United Kingdom">
                        </div>

                    </div>




                    <div style="border: 2px solid #da708f;padding: 15px;margin-bottom: 15px;">

                        <h5>If you would like to preorder your food and have it come at a later date, please click here</h5>

                        <div class="form-group">

                            <select class="form-control" id="preorder_datetime"  name="preorder_datetime">
                                @foreach($alltimeArray as $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div style="border: 2px solid #da708f;padding: 15px;margin-bottom: 15px;">

                        <h5>How would you like to pay?</h5>
                        <p>Please click on your chosen method of payment below:</p>

                        <div class="card-group">

                            @if(session()->has('paymentMethod'))

                                @if(session('paymentMethod')=='Cash')

                                    <div class="card" style="border: 0px;">
                                        <img class="card-img-top" src="{{url('resources/images/cash.png')}}" style="width: 90px;height: 90px;margin-left: auto;margin-right: auto;">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-center">Cash</h5>
                                            <p class="card-text text-center">
                                                <label class="custom-control custom-radio">
                                                    <input name="paymentMethod" value="Cash" type="radio" checked class="custom-control-input paymentMethod" >
                                                    <span class="custom-control-indicator"></span>
                                                </label>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="card" style="border: 0px;">
                                        <img class="card-img-top" src="{{url('resources/images/paypal.png')}}" style="width: 90px;height: 90px;margin-left: auto;margin-right: auto;">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-center">Credit/Debit Card+£{{$gl_card_fee}}</h6>
                                            <p class="card-text text-center">
                                                <label class="custom-control custom-radio">
                                                    <input name="paymentMethod" value="Paypal" type="radio"  class="custom-control-input paymentMethod" >
                                                    <span class="custom-control-indicator"></span>
                                                </label>
                                            </p>

                                        </div>
                                    </div>


                                @else
                                    <div class="card" style="border: 0px;">
                                        <img class="card-img-top" src="{{url('resources/images/cash.png')}}" style="width: 90px;height: 90px;margin-left: auto;margin-right: auto;">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-center">Cash</h5>
                                            <p class="card-text text-center">
                                                <label class="custom-control custom-radio">
                                                    <input name="paymentMethod" value="Cash" type="radio" class="custom-control-input paymentMethod" >
                                                    <span class="custom-control-indicator"></span>
                                                </label>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="card" style="border: 0px;">
                                        <img class="card-img-top" src="{{url('resources/images/paypal.png')}}" style="width: 90px;height: 90px;margin-left: auto;margin-right: auto;">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-center">Credit/Debit Card+£{{$gl_card_fee}}</h6>
                                            <p class="card-text text-center">
                                                <label class="custom-control custom-radio">
                                                    <input name="paymentMethod" value="Paypal" type="radio" checked class="custom-control-input paymentMethod" >
                                                    <span class="custom-control-indicator"></span>
                                                </label>
                                            </p>

                                        </div>
                                    </div>
                                @endif




                            @else

                                <div class="card" style="border: 0px;">
                                    <img class="card-img-top" src="{{url('resources/images/cash.png')}}" style="width: 90px;height: 90px;margin-left: auto;margin-right: auto;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-center">Cash</h5>
                                        <p class="card-text text-center">
                                            <label class="custom-control custom-radio ">
                                                <input name="paymentMethod" value="Cash" type="radio" class="custom-control-input paymentMethod" >
                                                <span class="custom-control-indicator"></span>
                                            </label>
                                        </p>

                                    </div>
                                </div>
                                <div class="card" style="border: 0px;">
                                    <img class="card-img-top" src="{{url('resources/images/paypal.png')}}" style="width: 90px;height: 90px;margin-left: auto;margin-right: auto;">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-center">Credit/Debit Card+£{{$gl_card_fee}}</h6>
                                        <p class="card-text text-center">

                                            <label class="custom-control custom-radio">
                                                <input name="paymentMethod" value="Paypal" type="radio" checked class="custom-control-input paymentMethod" >
                                                <span class="custom-control-indicator"></span>
                                            </label>
                                        </p>

                                    </div>
                                </div>


                            @endif


                        </div>



                    </div>

                    <br>

                     <button type="submit" class="btn btn-success btn-block">Confirm & Place my order</button>
                    <br>
                </div>

                <!--右侧-->

                <div class="col-md-3">
                    <!-- 营业时间 -->
                    <div style="border: 2px solid #afd136;padding: 15px;margin-bottom: 15px;">
                        <div class="alert" style="background-color: #bf4166" role="alert">
                            <h5 style="color: #ffffff;">Delivery Information</h5>
                        </div>

                        <ul class="list-group infoperdivmargin">
                            <li class="list-group-item" style="border: 0px;">
                                <p>Our store's postcode is:<br> <span style="color: #bf4166;font-weight: bold">{{$gl_postcode}}</span>, our maximum distance is <span style="color: #bf4166;font-weight: bold">{{$gl_maxdelivery}} miles</span> from our store location.</p>

                                <p>If you choose delivery your order, please make sure press 'Check Postcode' button to check whether your location is in our delivery zone.</p>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>



            <input type="hidden" id="priceInput" name="price" value="{{$total+$gl_card_fee}}">
            <input type="hidden" id="delivery_feeInput" name="delivery_fee" value="0">
            <input type="hidden" id="totalOrg" name="totalOrg" value="{{$total}}">
        </form>
    </div>


    <script>

        $('#formID').on('submit', function(event) {
            event.preventDefault();
            var url = "{{url('deliveryFeeAndCardFee')}}";
            var payment = $('input[name=paymentMethod]:checked').val();
            @if(Auth::user()->deli_method == 'Delivery')
                var postcode = $('#postcodeInput').val();
            @endif

            $.ajax({
                method: "POST",
                url: url,


                @if(Auth::user()->deli_method == 'Delivery')
                data: { "_token": "{{ csrf_token()}}","paymentMethod": payment,"postcode": postcode},
                @else
                data: { "_token": "{{ csrf_token()}}","paymentMethod": payment},
                @endif

                dataType: 'json',
                success: (function( response ) {


                    var responseN = Number(response['extratotal']);
                    var totalOrg = $('#totalOrg').val();
                    var totalOrgN = Number(totalOrg);
                    var sum = responseN+totalOrgN;
                    $('#priceInput').val(sum.toFixed(2));
                    $('#total_price_div').text(sum.toFixed(2));
                    var delivery_fee = Number(response['delivery_fee']);
                    $('#delivery_feeInput').val(delivery_fee);
                    $('#delivery_fee_div').text(delivery_fee);
                    console.log('paymentMethod success');


                    if(response['statuscode']=='invalidpostcode'){
                        alert(response['info']);
                    }else if(response['statuscode']=='freedelievery'){
                     //submit先解禁 再提交
                        $('#formID').off('submit');
                        $('#formID').submit();
                    }else if(response['statuscode']=='delievery'){
                     //submit
                        $('#formID').off('submit');
                        $('#formID').submit();
                    }else if(response['statuscode']=='outofdelievery'){
                        alert(response['info']);
                    }else if(response['statuscode']=='collection'){
                        //submit
                        $('#formID').off('submit');
                        $('#formID').submit();
                    }




                })
            });






        });

        $(document).on("click","#postcodechecker",function(){

            var payment = $('input[name=paymentMethod]:checked').val();
            var postcode = $('#postcodeInput').val();
            var url = "{{url('deliveryFeeAndCardFee')}}";



            $.ajax({
                method: "POST",
                url: url,
                data: { "_token": "{{ csrf_token()}}","paymentMethod": payment,"postcode": postcode},
                dataType: 'json',
                success: (function( response ) {

                    var extratotal = Number(response['extratotal']);
                    var totalOrg = $('#totalOrg').val();
                    var totalOrgN = Number(totalOrg);
                    var sum = extratotal+totalOrgN;
                    $('#priceInput').val(sum.toFixed(2));
                    $('#total_price_div').text(sum.toFixed(2));

                    var delivery_fee = Number(response['delivery_fee']);
                    $('#delivery_feeInput').val(delivery_fee);
                    $('#delivery_fee_div').text(delivery_fee);

                    alert(response['info']);
                    console.log('paymentMethod success');

                })
            });

        });


        $(document).on("click",".paymentMethod",function(){

            var url = "{{url('deliveryFeeAndCardFee')}}";

            var payment = $('input[name=paymentMethod]:checked').val();
            @if(Auth::user()->deli_method == 'Delivery')
                var postcode = $('#postcodeInput').val();
            @endif

            $.ajax({
                method: "POST",
                url: url,


                @if(Auth::user()->deli_method == 'Delivery')
                    data: { "_token": "{{ csrf_token()}}","paymentMethod": payment,"postcode": postcode},
                @else
                    data: { "_token": "{{ csrf_token()}}","paymentMethod": payment},
                @endif

                dataType: 'json',
                success: (function( response ) {


                    var responseN = Number(response['extratotal']);


                    var totalOrg = $('#totalOrg').val();
                    var totalOrgN = Number(totalOrg);

                    var sum = responseN+totalOrgN;

                    $('#priceInput').val(sum.toFixed(2));
                    $('#total_price_div').text(sum.toFixed(2));

                    var delivery_fee = Number(response['delivery_fee']);
                    $('#delivery_feeInput').val(delivery_fee);
                    $('#delivery_fee_div').text(delivery_fee);
                    console.log('paymentMethod success');

                })
            });

        });


    </script>


@endsection

