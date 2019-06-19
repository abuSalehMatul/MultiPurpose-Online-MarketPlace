@extends('coupon.layouts.admin')
@section('content')
  <div class="admin-form-main-block mrgn-t-40">
    <h4 class="admin-form-text"><a href="{{route('social.index')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Add Social</h4> 
    {!! Form::open(['method' => 'POST', 'action' => 'SocialController@store']) !!}
      <div class="row admin-form-block z-depth-1">
        <div class="col-md-6">
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            {!! Form::label('title', 'Social Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('title') }}</small>
          </div>
          <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }} currency-symbol-block">
            {!! Form::label('icon', 'Social Symbol') !!}
            <p class="inline info"> - Please select social symbol</p>
              <div class="input-group">
                {!! Form::text('icon', null, ['class' => 'form-control social-icon-picker']) !!}
                <span class="input-group-addon simple-input"><i class="glyphicon glyphicon-user"></i></span>
              </div>
            <small class="text-danger">{{ $errors->first('icon') }}</small>
          </div>
          <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
            {!! Form::label('url', 'Social Url') !!}
            {!! Form::text('url', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('url') }}</small>
          </div>
          <div class="btn-group pull-right">
            <button type="reset" class="btn btn-info">Reset</button>
            <button type="submit" class="btn btn-success">Create</button>
          </div>
          <div class="clear-both"></div>
        </div>  
      </div>
    {!! Form::close() !!}
  </div>
@endsection
@section('custom-script')
<script>
  $(function () {
    $('.social-icon-picker').iconpicker({
      title: 'Social Symbols',
      icons: ['fa fa-facebook', 'fa fa-twitter', 'fa fa-pinterest', 'fa fa-github', 'fa fa-google', 'fa fa-instagram', 'fa fa-flickr', 'fa fa-dribbble', 'fa fa-youtube'],
      selectedCustomClass: 'label label-primary',
      mustAccept: false,
      placement: 'rightBottom',
      showFooter: false,
      hideOnSelect: true,
    });
  });
</script>
@endsection