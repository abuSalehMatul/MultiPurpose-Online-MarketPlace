@extends('coupon.layouts.admin')
@section('content')
  <div class="admin-form-main-block mrgn-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/category')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Edit Category</h4> 
    {!! Form::model($category, ['method' => 'PATCH', 'action' => ['CategoryController@update', $category->id], 'files' => true]) !!}
      <div class="row admin-form-block z-depth-1">
        <div class="col-md-6">
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
              {!! Form::label('title', 'Title') !!}
              {!! Form::text('title', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('title') }}</small>
          </div>
          <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
              {!! Form::label('is_active', 'Status') !!}
              {!! Form::select('is_active', ['1' => 'Active', '0' => 'Deactive'], null, ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('is_active') }}</small>
          </div>
          <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }} currency-symbol-block">
            {!! Form::label('icon', 'Category Symbol') !!}
            <p class="inline info"> - Please select catgeory symbol or category image</p>
              <div class="input-group">
                {!! Form::text('icon', null, ['class' => 'form-control category-icon-picker']) !!}
                <span class="input-group-addon simple-input"><i class="glyphicon glyphicon-user"></i></span>
              </div>
            <small class="text-danger">{{ $errors->first('icon') }}</small>
          </div>
          <h6 class="text-center"><b>OR</b></h6>
          <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} input-file-block">
            {!! Form::label('image', 'Category Image') !!} - <p class="inline info">Help block text</p>
            {!! Form::file('image', ['class' => 'input-file', 'id'=>'image']) !!}
            <label for="image" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Category Image">
              <i class="icon fa fa-check"></i>
              <span class="js-fileName">Choose a File</span>
            </label>
            <p class="info">Choose custom image</p>
            <small class="text-danger">{{ $errors->first('image') }}</small>
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