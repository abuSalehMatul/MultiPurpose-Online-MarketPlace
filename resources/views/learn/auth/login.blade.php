@extends('layout')

@section('content')
<section class="starts-area" >
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-uppercase text-center">{{$page_title}}</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" class="controls">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="username"
                                       class="{{ $errors->has('username') ? ' is-invalid' : '' }} form-control"
                                       value="{{ old('username') }}" placeholder=" Username">
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback ">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Password"
                                       class="{{ $errors->has('password') ? ' is-invalid' : '' }} form-control">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback ">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">

                                <input type="submit" class="btn btn-block btn-primary" value="Login">
                            </div>

                            <a href="{{ route('password.request') }}">Forget Password ?</a>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
