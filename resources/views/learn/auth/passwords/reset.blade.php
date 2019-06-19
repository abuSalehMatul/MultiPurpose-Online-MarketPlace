@extends('layout')

@section('content')
    <section class="starts-area" >
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{$page_title}}</h3>
                        </div>
                        <div class="card-body">

                            @include('errors.error')
                            @if (session()->has('message'))
                                <div class="alert alert-{{ session()->get('type') }} alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            @if (session()->has('status'))
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            <br>
                            <div class="login-form">
                                <form  method="POST" action="{{ route('user.password.request') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <input type="text" name="email" id="email"  value="{{$email}}" class="form-control" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" required placeholder="Enter your Password" class="form-control"/>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Confirm Password" class="form-control"/>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-block btn-primary" value="Reset Password">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

@endsection
