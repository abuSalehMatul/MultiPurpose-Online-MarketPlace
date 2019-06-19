@extends('coupon.layouts.admin')
@section('content')
  <div class="admin-form-main-block mrgn-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/forumcategory')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Edit Forum Category</h4> 
    {!! Form::model($forumcategory, ['method' => 'PATCH', 'action' => ['ForumCategoryController@update', $forumcategory->id]]) !!}
      <div class="row admin-form-block z-depth-1">
        <div class="col-md-8">
          <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
              {!! Form::label('category', 'Select Forum Type') !!} - <p class="inline info">Type of coupon, deal, discussion</p>
              {!! Form::select('category', ['c' => 'Coupon','d' => 'Deal', 'g' => 'General'], null, ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('category') }}</small>
          </div> 
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
              {!! Form::label('title', 'Forum Name / Title') !!}
              {!! Form::text('title', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('title') }}</small>
          </div> 
          <div class="summernote-main form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
              {!! Form::label('detail', 'Forum Description') !!} - <p class="inline info">Short description</p>
              {!! Form::textarea('detail', null, ['id' => 'summernote-main','class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('detail') }}</small>
          </div> 
          <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }} switch-main-block">
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('is_active', 'Status') !!}
              </div>
              <div class="col-xs-5 pad-0">
                <label class="switch">                
                  {!! Form::checkbox('is_active', null, null, ['class' => 'checkbox-switch']) !!}
                  <span class="slider round"></span>
                </label>
              </div>
            </div>
            <div class="col-xs-12">
              <small class="text-danger">{{ $errors->first('is_active') }}</small>
            </div>
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