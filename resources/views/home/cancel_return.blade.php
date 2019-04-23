@extends('home.layout.layout')

@section('content')

    <div class="container" style="margin-top: 30px;">
        <div class="row justify-content-center">
        <div class="media col-sm-12 col-md-8 ">
            <img class="d-flex mr-3" src="{{url('resources/images/paysuc/rejected.png')}}">
            <div class="media-body">
                <h5 class="mt-0">Faild !</h5>
                <p>Unfortunately your payment has failed, please retry </p>

                <br>
                <p><a href="{{url('retry_paypal/'.$oneorder->id)}}">Try again now</a></p>
                <p><a href="{{url('myorders')}}">View my orders</a></p>
            </div>
        </div>
        </div>

    </div>


@endsection

