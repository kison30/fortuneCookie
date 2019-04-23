@extends('home.layout.layout')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <nav class="nav nav-pills flex-column flex-sm-row">
            <a class="flex-sm-fill text-sm-center nav-link active"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Orders</a>
        </nav>
    </div>

    <div class="wrapperPost" style="background-color: #ffffff;">

        <div class="container" style="padding-top: 30px;">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($all as $value)
                <tr>
                    <th scope="row">{{$value->id}}</th>
                    <td>{{Carbon\Carbon::parse($value->created_at)->diffForHumans()}}</td>
                    <td>£{{$value->price}}</td>
                    <td>
                        @if($value->order_pay=='Unpaid')
                            <span style="color: red">{{$value->order_pay}}</span>
                        @else
                            {{$value->order_pay}}
                        @endif

                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="{{url('vieworder/'.$value->id)}}" role="button">View</a>
                        @if($value->paymentMethod=='Paypal' && $value->order_pay=='Unpaid')
                            <a class="btn btn-sm btn-danger" href="{{url('retry_paypal/'.$value->id)}}" role="button">Pay Now</a>
                        @endif

                    </td>
                </tr>

                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No data
                        </td>


                    </tr>
                @endforelse

                </tbody>
            </table>
            <div class="page_list float-right" style="margin-bottom: 50px;">
                {{$all->links()}}
            </div>

        </div>



    </div>

@endsection
