@extends('layouts.admin')
@section('content')
  <div class="admin-form-main-block mrgn-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/user')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Create User</h4>
    <div class="admin-form-block z-depth-1">          
      {!! Form::open(['method' => 'POST', 'action' => 'UserController@store', 'files' => true]) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Enter Name') !!} 
              <p class="inline info"> - Please enter your name</p>
              {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'autofocus']) !!}
              <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>         
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              {!! Form::label('email', 'Enter Your Email ID*') !!} - <p class="inline info">Please enter your email</p>
              {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('email') }}</small>
            </div>
            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
              {!! Form::label('mobile', 'Enter Your Mobile Number*') !!} - <p class="inline info">Please enter your mobile number</p>
              {!! Form::text('mobile', null, ['class' => 'form-control', 'required']) !!}
              <small class="text-danger">{{ $errors->first('mobile') }}</small>
            </div> 
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::label('password', 'Password') !!}
              <p class="inline info"> - Please enter your password</p>
              {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('password') }}</small>
            </div>
            <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
              {!! Form::label('confirm_password', 'Confirm Password') !!}
              <p class="inline info"> - Please enter your password again</p>
              {!! Form::password('confirm_password', ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('confirm_password') }}</small>
            </div>
            <div class="form-group{{ $errors->has('is_admin') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_admin', 'Administrator') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">								
                    {!! Form::checkbox('is_admin', 1, 0, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_admin') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} input-file-block">
              {!! Form::label('image', 'User Image') !!} - <p class="inline info">Help block text</p>
              {!! Form::file('image', ['class' => 'input-file', 'id'=>'image']) !!}
              <label for="image" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="User Image">
                <i class="icon fa fa-check"></i>
                <span class="js-fileName">Choose a File</span>
              </label>
              <p class="info">Choose custom image</p>
              <small class="text-danger">{{ $errors->first('image') }}</small>
            </div>
          </div>
          <div class="col-md-6">            
            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
              {!! Form::label('gender', 'Choose Your Gender') !!}
              {!! Form::select('gender', ['m' => 'Male', 'f' => 'Female'], null, ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('gender') }}</small>
            </div> 
            <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
              {!! Form::label('dob', 'Date of Birth') !!} - <p class="inline info">Please enter your dob</p>
              {!! Form::date('dob', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('dob') }}</small>
            </div> 
            <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
              {!! Form::label('website', 'Enter Your Website') !!} - <p class="inline info">Please enter website link if any</p>
              {!! Form::text('website', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('website') }}</small>
            </div>
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
              {!! Form::label('address', 'Enter Your Address') !!} - <p class="inline info">Please enter your address</p>
              {!! Form::textarea('address', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('address') }}</small>
            </div> 
            <div class="form-group{{ $errors->has('brief') ? ' has-error' : '' }}">
              {!! Form::label('brief', 'Biography') !!} - <p class="inline info">Please enter about you</p>
              {!! Form::textarea('brief', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('brief') }}</small>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="btn-group pull-right">
              <button type="reset" class="btn btn-info">Reset</button>
              <button type="submit" class="btn btn-success">Create</button>
            </div>
            <div class="clear-both"></div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection
@section('custom-script')
<script>
  $(function(){
    $('form').on('submit', function(event){
      $('.loading-block').addClass('active');
    });
  });
</script>
@endsection