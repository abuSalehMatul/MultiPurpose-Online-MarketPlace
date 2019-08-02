@extends('master_backend.master')
@section('content')

<head>
	<title>Laravel </title>
	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
     {{-- {!! NoCaptcha::renderJs() !!} --}}
     <style>
      
     
     </style>
</head>

  
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1 class="text-info offset-1">Login</h1>
                </div>
                <div class="panel-body">
                    <form id="myform" class="form-horizontal" role="form" method="POST" action="{{ url('/master-admin-login') }}">
                        {!! csrf_field() !!}
   
                       
   
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Primary E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="primary_email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Secondary E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="secondary_email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
   
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <br/>
                                <button type="submit"  class="btn btn-primary" >
                                    <i class="fa fa-btn fa-user" onclick="showform()"></i>Next
                               
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>



@endsection