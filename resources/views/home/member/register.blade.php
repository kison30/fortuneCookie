@extends('home.layout.layout')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{url('resources/views/home/style/memberlogin.css')}}" />
    <div class="container main">

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



        <div class="row">

            <div class="col-12 col-md-6 mx-auto">
                <div class="card card-block card-border">
                    <h3 class="card-title title-align">Register now, it's free!</h3>
                    <form name="regForm" id="formID" method="post" action="{{url('register_do')}}">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="username" class="col-4 col-md-4 col-form-label text-right">Email</label>
                            <div class="col-6 col-md-6">
                                <input type="text" name="username" @if(session()->has('username')) value="{{session('username')}}" @endif class="form-control" id="username">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="password" class="col-4 col-md-4 col-form-label text-right">Password</label>
                            <div class="col-6 col-md-6">
                                <input type="password" name="password" @if(session()->has('password')) value="{{session('password')}}" @endif class="form-control" id="password">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="password_confirmation" class="col-4 col-md-4 col-form-label text-right">Confirm Password</label>
                            <div class="col-6 col-md-6">
                                <input type="password" name="password_confirmation" class="form-control"  id="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="firstName" class="col-4 col-md-4 col-form-label text-right">First Name</label>
                            <div class="col-6 col-md-6">
                                <input type="text" name="firstName"  @if(session()->has('firstName')) value="{{session('firstName')}}"  @endif class="form-control"  id="firstName">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="lastName" class="col-4 col-md-4 col-form-label text-right">Last Name</label>
                            <div class="col-6 col-md-6">
                                <input type="text" name="lastName"  @if(session()->has('lastName')) value="{{session('lastName')}}"  @endif class="form-control"  id="lastName">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="inputMobile" class="col-4 col-md-4 col-form-label text-right">Mobile</label>
                            <div class="col-6 col-md-6">
                                <input type="text" name="mobile"   @if(session()->has('mobile')) value="{{session('mobile')}}" @else value="+44"  @endif class="form-control"  id="inputMobile">
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="address" class="col-4 col-md-4 col-form-label text-right">Address</label>
                            <div class="col-6 col-md-6">
                                <input type="text" name="address"  @if(session()->has('address')) value="{{session('address')}}"  @endif class="form-control" id="address">
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="postcode" class="col-4 col-md-4 col-form-label text-right">Postcode</label>
                            <div class="col-4 col-md-4">
                                <input type="text" name="postcode"  @if(session()->has('postcode')) value="{{session('postcode')}}" @endif class="form-control"  id="postcode">
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="city" class="col-4 col-md-4 col-form-label text-right">Town/City</label>
                            <div class="col-6 col-md-6">
                                <input type="text" name="city" @if(session()->has('city')) value="{{session('city')}}" @endif class="form-control" id="city">
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="country" class="col-4 col-md-4 col-form-label text-right">Country</label>
                            <div class="col-6 col-md-6">
                                <select class="form-control" id="country" name="country">
                                    <option value="United Kingdom" selected>United Kingdom</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-6 col-md-6">
                                <label class="form-check-label">
                                    <input type="checkbox" name="agree" checked id="agree"> I accept all of the <a href="" target="_blank">Terms & Conditions</a>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <input type="submit" class="btn btn-success" value="Register" style="cursor: pointer">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
