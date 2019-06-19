@extends('coupon.layouts.admin')
@section('content')
  <div class="admin-form-main-block mrgn-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/pages')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Edit Pages</h4> 
    {!! Form::model($pages, ['method' => 'PATCH', 'action' => ['PagesController@update', $pages->id]]) !!}
      <div class="row admin-form-block z-depth-1">
        <div class="col-md-12">
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
              {!! Form::label('title', 'Page Title') !!}
              {!! Form::text('title', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('title') }}</small>
          </div>
          <div class="summernote-main form-group{{ $errors->has('body') ? ' has-error' : '' }}">
            {!! Form::label('body', 'Page Body') !!}
            {!! Form::textarea('body', null, ['id' => 'summernote-main', 'class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('body') }}</small>
          </div>
          <div class="form-group{{ $errors->has('widget') ? ' has-error' : '' }}">
              {!! Form::label('widget', 'Select Footer Widget') !!}
              {!! Form::select('widget', ['1' => 'None', '2' => 'Widget 1', '3' => 'Widget 2', '4' =>'Widget 3'], null, ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('widget') }}</small>
          </div>
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-success">Update</button>
          </div>
          <div class="clear-both"></div>
        </div>  
      </div>
    {!! Form::close() !!}
  </div>
@endsection