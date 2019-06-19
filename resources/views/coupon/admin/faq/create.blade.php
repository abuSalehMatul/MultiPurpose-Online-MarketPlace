@extends('coupon.layouts.admin')
@section('content')
  <div class="admin-form-main-block mrgn-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/faq')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Add Faq</h4> 
    {!! Form::open(['method' => 'POST', 'action' => 'FaqController@store']) !!}
      <div class="row admin-form-block z-depth-1">
        <div class="col-md-12">
          <div class="form-group{{ $errors->has('faq_category_id') ? ' has-error' : '' }}">
              {!! Form::label('faq_category_id', 'Select a Category') !!} - <p class="inline info">Please select a faq catergory</p>
              {!! Form::select('faq_category_id', $categories, null, ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('faq_category_id') }}</small>
          </div>
          <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
              {!! Form::label('question', 'Faq Question') !!} - <p class="inline info">Please enter a question</p>
              {!! Form::text('question', null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('question') }}</small>
          </div>
          <div class="summernote-main form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
            {!! Form::label('answer', 'Faq Answer') !!} - <p class="inline info">Please select a answer</p>
            {!! Form::textarea('answer', null, ['id' => 'summernote-main', 'class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('answer') }}</small>
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