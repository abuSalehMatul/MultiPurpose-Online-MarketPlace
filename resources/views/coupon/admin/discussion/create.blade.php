@extends('coupon.layouts.admin')
@section('content')
  <div class="admin-form-main-block mrgn-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/discussion')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Add Deal/Discussion</h4> 
    {!! Form::open(['method' => 'POST', 'action' => 'DiscussionController@store', 'files' => true]) !!}
      <div class="row admin-form-block z-depth-1">
        <div class="col-md-8">
          <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
              {!! Form::label('user_id', 'Select User*') !!} - <p class="inline info">Please select user name</p>
              {!! Form::select('user_id', $all_users, null, ['class' => 'form-control select2', 'required']) !!}
              <small class="text-danger">{{ $errors->first('user_id') }}</small>
          </div>            
          <div class="form-group{{ $errors->has('forum_category_id') ? ' has-error' : '' }}">
              {!! Form::label('forum_category_id', 'Select Forum Name*') !!} - <p class="inline info">Please select forum type</p>
              {!! Form::select('forum_category_id', $cat_discussion, null, ['class' => 'form-control select2', 'required']) !!}
              <small class="text-danger">{{ $errors->first('forum_category_id') }}</small>
          </div> 
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
              {!! Form::label('title', 'Discussion Name/Title*') !!} - <p class="inline info">Please enter discussion title</p>
              {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
              <small class="text-danger">{{ $errors->first('title') }}</small>
          </div> 
          <div class="summernote-main form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
              {!! Form::label('detail', 'Description*') !!} - <p class="inline info">Please enter desciption</p>
              {!! Form::textarea('detail', null, ['id' => 'summernote-main', 'class' => 'form-control', 'required']) !!}
              <small class="text-danger">{{ $errors->first('detail') }}</small>
          </div>
          <div class="form-group{{ $errors->has('is_featured') ? ' has-error' : '' }} switch-main-block">
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('is_featured', 'Featured') !!}
              </div>
              <div class="col-xs-5 pad-0">
                <label class="switch">                
                  {!! Form::checkbox('is_featured', 1, 1, ['class' => 'checkbox-switch']) !!}
                  <span class="slider round"></span>
                </label>
              </div>
            </div>
            <div class="col-xs-12">
              <small class="text-danger">{{ $errors->first('is_featured') }}</small>
            </div>
          </div> 
          <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }} switch-main-block">
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('is_active', 'Status') !!}
              </div>
              <div class="col-xs-5 pad-0">
                <label class="switch">                
                  {!! Form::checkbox('is_active', 1, 1, ['class' => 'checkbox-switch']) !!}
                  <span class="slider round"></span>
                </label>
              </div>
            </div>
            <div class="col-xs-12">
              <small class="text-danger">{{ $errors->first('is_active') }}</small>
            </div>
          </div>
          <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} input-file-block">
            {!! Form::label('image', 'Discussion Image') !!} 
            {!! Form::file('image', ['class' => 'input-file', 'id'=>'image']) !!}
            <label for="image" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Discussion Image">
              <i class="icon fa fa-check"></i>
              <span class="js-fileName">Choose a File</span>
            </label>
            <p class="info">Choose custom image</p>
            <small class="text-danger">{{ $errors->first('image') }}</small>
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
    $('#type').on('change', function() {
      if ( this.value == 'c'){
        $("#code").show();
      }
      else 
        $("#code").hide(); 
    }).trigger("change");
  </script>