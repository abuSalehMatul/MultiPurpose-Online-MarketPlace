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

                            <form method="POST" action="{{ route('user.password.email') }}" class="controls">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="text" name="email" id="email" required placeholder="Enter your Email" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value=" Send Password Reset Link" class="btn btn-block btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


@endsection
