@extends('home.layout.layout')

@section('content')
    <div class="container" style="margin-top: 20px;margin-bottom: 90px;">
        <nav class="nav nav-pills flex-column flex-sm-row">
            <a class="flex-sm-fill text-sm-center nav-link active" href="{{url('myorders')}}"> Back</a>
        </nav>
    </div>

    <div class="wrapperPost" style="background-color: #f5f5f5;">

        <div class="container" style="padding-top: 30px;">

                <div class="row justify-content-md-center">
                    <div class="col-md-8 col-sm-12">
                    <div class="card" style="padding: 15px;">

                        @foreach($one as $key => $value)

                            @if($key =='goodsArray')

                                    <div class="form-group row">
                                        <label for="province_id" class="col-sm-3 col-form-label">Order details</label>
                                        <div class="col-sm-9">

                                            <table class="table">

                                                <tbody>

                                                @foreach($value as $k => $val)
                                                <tr>
                                                    <td>{{$val['name']}}</td>
                                                    <td>{{$val['num']}}</td>
                                                    <td>{{$val['price']}}</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>


                                        </div>
                                    </div>




                            @else
                                <div class="form-group row">
                                    <label for="province_id" class="col-sm-3 col-form-label">{{ucfirst($key)}}</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{$value}}" class="form-control" disabled  >
                                    </div>
                                </div>
                            @endif



                        @endforeach


                    </div>
                    </div>
                </div>


        </div>

    </div>

@endsection
