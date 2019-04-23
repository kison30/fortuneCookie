<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{url('resources/views/home/style/basic.css')}}" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>

    <meta name="keywords" content="chinese|takeaway|restaurant|{{$gl_city}}|{{$gl_postcode}}" />
    <meta name="description" content="chinese restaurant takeaway in {{$gl_city}},{{$gl_postcode}}">

    <title>{{$gl_title}}</title>

</head>

<body>

<nav class="navbar navbar-expand-md" style="border-bottom: 5px solid #28a745">
    <a class="navbar-brand" href="{{url('/')}}"><img src="{{url('resources/images/logo.png')}}" width="160" height="60"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>


        @if($gl_is_open =='yes')
            <span class="open">Open</span>
        @else
            <span class="closed">Close</span>
        @endif


    <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav mr-auto">


        </ul>


            @if(Auth::check())
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle btn-outline-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth::user()->firstname}} {{Auth::user()->lastname}}
                        <img class="rounded-circle" src="{{asset('resources/images/user01.png')}}" width="22" height="22" />



                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('myorders')}}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Orders</a>
                        <a class="dropdown-item" href="{{url('profile')}}"><i class="fa fa-cog" aria-hidden="true"></i> Profile</a>
                        <a class="dropdown-item" href="{{url('password')}}"><i class="fa fa-lock" aria-hidden="true"></i> Password</a>
                        <a class="dropdown-item" href="{{url('logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a>
                    </div>
                </div>
            @else
                <a href="{{url('login')}}" class="btn btn-sm btn-success" role="button" aria-pressed="true">Sign in</a>
                <a href="{{url('register')}}" class="btn btn-sm btn-success" role="button" aria-pressed="true">Sign up</a>

            @endif




    </div>
</nav>






@yield('content')

<div class="container-fluid" style="margin-top: 100px;padding-top:15px;background-color: #EEEEEE">

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <img width="50" height="32" src="{{url('resources/images/payment/visa.png')}}">
            <img width="50" height="32" src="{{url('resources/images/payment/mastercard.png')}}">
            <img width="50" height="32" src="{{url('resources/images/payment/discover.png')}}">
            <img width="50" height="32" src="{{url('resources/images/payment/american-express.png')}}">
            <img width="50" height="32" src="{{url('resources/images/payment/paypal.png')}}">
            <img width="50" height="32" src="{{url('resources/images/payment/maestro.png')}}">
        </div>
        <div class="col-md-6 col-sm-12">
            <p>{{$gl_address}}, {{$gl_city}}, {{$gl_postcode}} Openning time: 17:00-23:00 </p>
            <p>Copyright © 2017 {{$gl_shopname}}</p>
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>



@if(isset($is_index) && $is_index=='yes')
    <script type="text/javascript" src="{{url('resources/js/index.js')}}"></script>
@endif


</body>


</html>
