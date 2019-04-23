@extends('home.layout.layout')

@section('content')

    <div class="container" style="margin-top: 30px;">
        <div class="row justify-content-center">
        <div class="media col-sm-12 col-md-8 ">
            <img class="d-flex mr-3" src="{{url('resources/images/paysuc/accepted.png')}}">
            <div class="media-body">
                <h5 class="mt-0">Thank you for your order !</h5>
                <p>We received your order and will process it as soon as possible. </p>
                <p>Your order Number:<br><b>{{$oneorder->ordernum}}</b></p>
                <p>Takeaway Type:<br><b>{{$oneorder->takeawayType}}</b></p>
                <p>Payment Method:<br><b>{{$oneorder->paymentMethod}}</b></p>

                <br>
                <p><a href="{{url('/')}}">Continue to order</a></p>
                <p><a href="{{url('vieworder/'.$oneorder->id)}}">View order details</a></p>
            </div>
        </div>
        </div>

    </div>


@endsection

