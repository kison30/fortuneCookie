@extends('home.layout.layout')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <nav class="nav nav-pills flex-column flex-sm-row">
            <a class="flex-sm-fill text-sm-center nav-link active"><i class="fa fa-lock" aria-hidden="true"></i> Change password</a>
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
                        <form method="post" action="{{url('password_do')}}">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="province_id" class="col-sm-3 col-form-label">Old password</label>
                                <div class="col-sm-9">
                                    <input type="password" name="old_password" class="form-control"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province_id" class="col-sm-3 col-form-label">New password</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password" class="form-control"    >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="province_id" class="col-sm-3 col-form-label">Confirm password</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password_confirmation" class="form-control"   >
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="city" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <input class="btn btn-block btn-primary" style="cursor: pointer" type="submit" name="send" value="Update">
                                </div>
                            </div>

                        </form>
                    </div>
                    </div>
                </div>


        </div>

    </div>

@endsection
