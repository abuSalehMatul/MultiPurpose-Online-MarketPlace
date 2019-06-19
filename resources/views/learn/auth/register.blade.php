@extends('layout')
@section('content')
    <section class="starts-area" >
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card" >
                        <div class="card-header">
                            <h3 class="card-title text-center">{{$page_title}}</h3>
                        </div>
                        <div class="card-body">

                            @if($basic->registration == 1)

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Enter Your Name" class=" {{ $errors->has('name') ? ' is-invalid' : '' }} form-control">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback error-color ">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="username" placeholder="Username" class=" {{ $errors->has('username') ? ' is-invalid' : '' }} form-control">
                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback error-color ">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Enter your E-mail" class="{{ $errors->has('email') ? ' is-invalid' : '' }} form-control">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback error-color ">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="phone" placeholder="Contact Number" class="{{ $errors->has('phone') ? ' is-invalid' : '' }} form-control">
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback error-color ">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }} form-control" placeholder="Enter Password">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback error-color ">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Re-Enter Password">
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-block btn-primary" value="SIGN UP">
                                    </div>

                                </form>

                                <span>Already have an account ? <a href="{{route('login')}}"> Sign In</a></span>

                            @else
                                <h3 class="text-danger">Registration Has been Closed By Admin</h3>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
