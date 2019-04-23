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

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif


        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="card card-block card-border">
                    <h3 class="card-title title-align">Aleady a member? Sign in</h3>
                    <form name="loginForm" method="post" action="{{url('login_do')}}">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="usernameLogin" class="col-4 col-md-4 col-form-label text-right">Email</label>
                            <div class="col-6 col-md-6">
                                <input type="email" name="username" class="form-control" id="usernameLogin">
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="passwordLogin" class="col-4 col-md-4 col-form-label text-right">Password</label>
                            <div class="col-6 col-md-6">
                                <input type="password" name="password" class="form-control" id="passwordLogin">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="passwordLogin" class="col-4 col-md-4 col-form-label"></label>
                            <div class="col-6 col-md-6">
                                <input type="submit" class="btn btn-success"  value="Sign in">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="passwordLogin" class="col-4 col-md-4 col-form-label"></label>
                            <div class="col-6 col-md-6">
                                <a href="{{url('register')}}" class="btn btn-outline-success" >Create an new account</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
