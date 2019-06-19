@extends('coupon.layouts.admin')
@section('content')
  <div class="admin-form-main-block mrgn-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/slider')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Edit Home Banner</h4> 
    {!! Form::model($slider, ['method' => 'PATCH', 'action' => ['SliderController@update', $slider->id], 'files' => true]) !!}
      <div class="row admin-form-block z-depth-1">
        <div class="col-md-6">
          {{-- <div class="form-group{{ $errors->has('is_image') ? ' has-error' : '' }}">
              {!! Form::label('is_image', 'Select Choice') !!}
              {!! Form::select('is_image', [1 => 'Image', 0 => 'Video'], null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('is_image') }}</small>
          </div>  --}}
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
              {!! Form::label('title', 'Banner Name') !!}
              {!! Form::text('title', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('title') }}</small>
          </div>           
          <div class="form-group{{ $errors->has('heading') ? ' has-error' : '' }}">
              {!! Form::label('heading', 'Banner Heading') !!}
              {!! Form::text('heading', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('heading') }}</small>
          </div>  
          <div class="form-group{{ $errors->has('subheading') ? ' has-error' : '' }}">
              {!! Form::label('subheading', 'Banner Subheading') !!}
              {!! Form::text('subheading', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('subheading') }}</small>
          </div> 
          {{-- <div id="video-block" class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
              {!! Form::label('link', 'Video Link') !!}
              {!! Form::text('link', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('link') }}</small>
          </div>  --}}  
          <div id="image-block" class="form-group{{ $errors->has('is_overlay') ? ' has-error' : '' }} switch-main-block">
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('is_overlay', 'Overlay') !!}
              </div>
              <div class="col-xs-5 pad-0">
                <label class="switch">                
                  {!! Form::checkbox('is_overlay', 1, 0, ['class' => 'checkbox-switch']) !!}
                  <span class="slider round"></span>
                </label>
              </div>
            </div>
            <div class="col-xs-12">
              <small class="text-danger">{{ $errors->first('is_overlay') }}</small>
            </div>
          </div>
          <div id="image-block" class="form-group{{ $errors->has('is_parallax') ? ' has-error' : '' }} switch-main-block">
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('is_parallax', 'Parallax Effect') !!}
              </div>
              <div class="col-xs-5 pad-0">
                <label class="switch">                
                  {!! Form::checkbox('is_parallax', 1, 0, ['class' => 'checkbox-switch']) !!}
                  <span class="slider round"></span>
                </label>
              </div>
            </div>
            <div class="col-xs-12">
              <small class="text-danger">{{ $errors->first('is_parallax') }}</small>
            </div>
          </div>
          <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }} switch-main-block">
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('is_active', 'Status') !!}
              </div>
              <div class="col-xs-5 pad-0">
                <label class="switch">                
                  {!! Form::checkbox('is_active', 1, 0, ['class' => 'checkbox-switch']) !!}
                  <span class="slider round"></span>
                </label>
              </div>
            </div>
            <div class="col-xs-12">
              <small class="text-danger">{{ $errors->first('is_active') }}</small>
            </div>
          </div>
          <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} input-file-block">
            {!! Form::label('image', 'Slider Image') !!} - <p class="inline info">Help block text</p>
            {!! Form::file('image', ['class' => 'input-file', 'id'=>'image']) !!}
            <label for="image" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Slider Image">
              <i class="icon fa fa-check"></i>
              <span class="js-fileName">Choose a File</span>
            </label>
            <p class="info">Choose custom image</p>
            <small class="text-danger">{{ $errors->first('image') }}</small>
          </div> 
        </div>
      </div>
    {!! Form::close() !!}
  </div>
@endsection
{{-- @section('custome-script')
  <script>
    $('#is_image').on('change', function() {
      if ( this.value == '1'){
        $("#image-block").show();
        $("#video-block").hide(); 
      }
      else 
        $("#image-block").hide();
        $("#video-block").show();  
    }).trigger("change");
  </script>
@endsection --}}