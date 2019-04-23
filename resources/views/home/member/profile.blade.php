@extends('home.layout.layout')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <nav class="nav nav-pills flex-column flex-sm-row mypostSubnav">
            <a class="flex-sm-fill text-sm-center nav-link active"><i class="fa fa-cog" aria-hidden="true"></i> My profile</a>
        </nav>
    </div>

    <div class="wrapperPost" style="background-color: #f5f5f5;">

        <div class="container" style="padding-top: 30px;">

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
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

            <div class="row justify-content-md-center">
                <div class="col-md-8 col-sm-12">
                    <div class="card" style="padding: 15px;">
                        <form method="post" action="{{url('profile_do')}}">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="province_id" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"value="{{Auth::user()->username}}"   disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province_id" class="col-sm-3 col-form-label">First Name</label>
                                <div class="col-sm-9">
                                        <input type="text" class="form-control"  name="firstname" @if(session()->has('firstname')) value="{{session('firstname')}}" @else  value="{{Auth::user()->firstname}}" @endif  >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="province_id" class="col-sm-3 col-form-label">Last Name</label>
                                <div class="col-sm-9">
                                        <input type="text" class="form-control" name="lastname" @if(session()->has('lastname')) value="{{session('lastname')}}" @else  value="{{Auth::user()->lastname}}" @endif  >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province_id" class="col-sm-3 col-form-label">Mobile</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mobile"  @if(session()->has('mobile')) value="{{session('mobile')}}" @else  value="{{Auth::user()->mobile}}" @endif >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province_id" class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="address" @if(session()->has('address')) value="{{session('address')}}" @else  value="{{Auth::user()->address}}" @endif  >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province_id" class="col-sm-3 col-form-label">Postcode</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="postcode"  @if(session()->has('postcode')) value="{{session('postcode')}}" @else  value="{{Auth::user()->postcode}}" @endif  >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province_id" class="col-sm-3 col-form-label">Town/City</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="city" @if(session()->has('city')) value="{{session('city')}}" @else  value="{{Auth::user()->city}}" @endif >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province_id" class="col-sm-3 col-form-label">Country</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  value="United Kingdom" disabled >
                                </div>
                            </div>





                            <div class="form-group row">
                                <label for="city" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <input class="btn btn-block btn-primary" style="cursor: pointer" type="submit"  value="确认提交">
                                </div>
                            </div>

                        </form>
                    </div>

                </div>



            </div>

        </div>

    </div>

@endsection
