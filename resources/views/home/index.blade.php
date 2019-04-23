@extends('home.layout.layout')

@section('content')

    <link rel="stylesheet" type="text/css" href="{{url('resources/views/home/style/index.css')}}" />

    <div class="alert alert-warning" role="alert" style="text-align: center;border-radius: 0px;margin-bottom: 0px;">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h4><i class="fa fa-phone" aria-hidden="true"></i> {{$gl_tel}}</h4>
            </div>

            <div class="col-md-6 col-sm-12">
                <h4>Order time <i class="fa fa-clock-o" aria-hidden="true"></i> {{$gl_openingstart}}-{{$gl_openingend}}</h4>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="padding-left: 0px;padding-right: 0px;margin-bottom: 30px;">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{url('resources/images/banner.jpg')}}">

                    <div class="carousel-caption d-none d-md-block" style="bottom:0px;padding-bottom: 0px;background-color: #ffffff;opacity: 0.8;filter: alpha(opacity=80);left: 0px;right: 0px;color:#b24619;">
                        <h3>Order Delicious Chinese Food From {{$gl_shopname}}</h3>
                    </div>


                </div>

            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </div>


    <div class="container-fluid">

        <div class="row">

            <!-- 左侧导航 -->
            <div class="col-md-2 col-sm-12  col-xm-12">

                <div class="leftnavpin" >

                    <h5>Categories</h5>


                    <ul class="list-group" style="overflow-y: scroll; height:450px;">
                        @foreach($AllMenu as $value)
                            <li id="{{$loop->index}}"  class="list-group-item list-group-item-action leftnav" style="cursor: pointer">{{$value->name}}</li>
                        @endforeach
                    </ul>

                </div>



            </div>
            <!-- 中间菜单 -->
            <div class="col-md-6 col-sm-12 col-xm-12" style="padding-left: 30px;">

                @foreach($AllGoods as $value)
                <div class="alert alert-success" role="alert" id="menu{{$loop->index}}">
                    <h5 class="alert-heading">{{$value->name}}

                        <a class="btn btn-sm btn-danger float-right" data-toggle="collapse" data-parent="#menuAccordion" href="#menuAccordion{{$value->id}}" aria-expanded="false" aria-controls="menuAccordion{{$value->id}}">
                            <i class="fa fa-arrow-circle-down" aria-hidden="true"></i>
                        </a>

                    </h5>
                </div>
                    <div id="menuAccordion{{$value->id}}" class="collapse show" role="tabpanel">
                        @foreach($value->goods as $val)

                                <div class="media">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1">{{$val->sn}} {{$val->name}}</h6>
                                        {{$val->description}}
                                    </div>
                                    <div>

                                        <span>£{{$val->price}}</span>
                                        @if(Auth::check())
                                            <div class="btn btn-sm btn-success addCart" id="{{$val->id}}" ><i class="fa fa-plus" aria-hidden="true"></i></div>
                                        @else
                                            <a class="btn btn-sm btn-success" href="{{url('login')}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                 </div>

                        @endforeach
                    </div>
                @endforeach


            </div>

            <!-- 右侧购物车 -->
            <div class="col-md-4 col-sm-12 col-xm-12">

                <div class="rightcartpin">
                        <ul class="list-group">
                            <li class="list-group-item"><h5>My Order</h5></li>
                            <li class="list-group-item">

                                @if($gl_collectionOnly==1)
                                    <label class="custom-control custom-radio">
                                        <input name="takeawayType" value="Collection" type="radio" checked class="custom-control-input" >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Collection Only</span>
                                    </label>
                                @elseif($gl_deliveryOnly==1)
                                    <label class="custom-control custom-radio">
                                        <input name="takeawayType" value="Delivery" type="radio" checked class="custom-control-input" >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Delivery Only ({{$gl_devilery_time}}mins)</span>
                                    </label>
                                @else
                                    @if(Auth::check())

                                        @if(Auth::user()->deli_method == 'Delivery')

                                            <label class="custom-control custom-radio">
                                                <input name="takeawayType" value="Collection" type="radio" class="custom-control-input changeDeli" >
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Collection</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input name="takeawayType" value="Delivery" type="radio" checked class="custom-control-input changeDeli" >
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Delivery ({{$gl_devilery_time}}mins)</span>
                                            </label>

                                        @else
                                            <label class="custom-control custom-radio">
                                                <input name="takeawayType" value="Collection" type="radio" checked class="custom-control-input changeDeli" >
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Collection</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input name="takeawayType" value="Delivery" type="radio"  class="custom-control-input changeDeli" >
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Delivery ({{$gl_devilery_time}}mins)</span>
                                            </label>

                                        @endif


                                    @else
                                        <label class="custom-control custom-radio">
                                            <input name="takeawayType" value="Collection" type="radio" class="custom-control-input changeDelitoLogin" >
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Collection</span>
                                        </label>
                                        <label class="custom-control custom-radio">
                                            <input name="takeawayType" value="Delivery" type="radio" checked class="custom-control-input changeDelitoLogin" >
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Delivery ({{$gl_devilery_time}}mins)</span>
                                        </label>
                                    @endif

                                @endif


                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>　Minimum Order Amount: £{{$gl_minprice}}
                            </li>
                            

                        </ul>

                        <div id="theOrder" >
                            <ul class="list-group">
                                <li class="list-group-item" style="padding: 0px;">
                                    <div  style="overflow-y: auto; height:180px;">

                                        <div class="table-responsive">
                                            <table class="table" style="border: 0px;">
                                                <tbody>
                                                <?php $sum = 0; ?>
                                                @if(Auth::check())

                                                    @if(isset($cartInfoArr) && count($cartInfoArr)>0)


                                                        @foreach($cartInfoArr as $val)
                                                            <?php
                                                                $sum = $sum + $val['num']*$val['price'];
                                                            ?>

                                                        <tr>
                                                            <td>{{$val['num']}} X {{$val['name']}}</td>
                                                            <td><span class="float-right">£{{$val['num']*$val['price']}}</span></td>
                                                            <td>
                                                                <a  class="btn btn-danger btn-sm delCart" id="{{$val['id']}}"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                                            </td>
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
                            </ul>
                            <ul class="list-group" style="margin-bottom: 0px;border: 0px;">
                                <li class="list-group-item" style="border: 0px;">
                                    <span class="float-right">Total: £<b id="totalprice">{{$sum}}</b></span>
                                </li>
                            </ul>

                            <div class="input-group" style="margin-top: 10px;">

                                <div class="input-group-addon" style="padding: 0px;width: 100%">
                                    @if(Auth::check())

                                        @if(Auth::user()->deli_method == 'Collection')
                                                <a class="btn btn-success btn-block" href="{{url('checkout')}}" style="border-radius: 0px">Checkout</a>
                                        @else

                                            @if($sum >= $gl_minprice)
                                                <a class="btn btn-success btn-block" href="{{url('checkout')}}" style="border-radius: 0px">Checkout</a>

                                            @else
                                                <button type="button" class="btn  btn-block btn-success" disabled>Checkout</button>
                                            @endif

                                        @endif



                                    @else
                                        <button type="button" class="btn  btn-block btn-success" disabled>Checkout</button>
                                    @endif
                                </div>

                            </div>
                        </div>

                </div>

            </div>




        </div>
    </div>

    <script type="text/javascript" src="{{url('resources/js/zebra_pin.min.js')}}"></script>


    <script>

        $(document).on("click",".changeDelitoLogin",function(){

            var url = "{{url('login')}}";

            window.location.replace(url);

        });

        $(document).on("click",".changeDeli",function(){

            var takeawayType = $('input[name=takeawayType]:checked').val();
            var url = "{{url('changeDeli')}}";

            if (takeawayType == 'Collection'){
                    $('.input-group-addon').html('<a class="btn btn-success btn-block" href="{{url("checkout")}}" style="border-radius: 0px">Checkout</a>');
            }else{

                var totalNum = Number($('#totalprice').text());
                if(totalNum>={{$gl_minprice}}){
                    $('.input-group-addon').html('<a class="btn btn-success btn-block" href="{{url("checkout")}}" style="border-radius: 0px">Checkout</a>');
                }else{

                    $('.input-group-addon').html('<button type="button" class="btn  btn-block btn-success" disabled>Checkout</button>');
                }
            }


            $.ajax({
                method: "POST",
                url: url,
                data: { "_token": "{{ csrf_token() }}","deli_method": takeawayType  },
                dataType: 'json',
                success: (function( response ) {

                    console.log('change method success');

                })
            })

        });


        $(document).on("click",".addCart",function(){

            var url = "{{url('addCart')}}";

            $.ajax({
                method: "POST",
                url: url,
                data: { "_token": "{{ csrf_token() }}","id": $(this).attr('id')  },
                dataType: 'json',
                success: (function( response ) {

                    $( "#theOrder" ).load( "{{url('showCart')}}", function( response, status, xhr ) {
                        if ( status == "success" ) {
                            //alert(response);
                        }
                    });


                })
            })

        });

        $(document).on("click",".delCart",function(){

            var url = "{{url('delCart')}}";

            $.ajax({
                method: "POST",
                url: url,
                data: { "_token": "{{ csrf_token() }}","id": $(this).attr('id')  },
                dataType: 'json',
                success: (function( response ) {

                    $( "#theOrder" ).load( "{{url('showCart')}}", function( response, status, xhr ) {
                        if ( status == "success" ) {

                        }
                    });


                })
            })


        });

        $(document).on("click",".clearCart",function(){

            var url = "{{url('clearCart')}}";

            $.ajax({
                method: "POST",
                url: url,
                data: { "_token": "{{ csrf_token() }}"},
                dataType: 'json',
                success: (function( response ) {

                    $( "#theOrder" ).load( "{{url('showCart')}}", function( response, status, xhr ) {
                        if ( status == "success" ) {

                        }
                    });


                })
            })


        });




    </script>




@endsection

