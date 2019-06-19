@extends('admin.layout.master')
@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title ">{{$page_title}}
                    <a href="{{route('admin.testimonial')}}" class="btn btn-success btn-md pull-right ">
                        <i class="fa fa-eye"></i> All Testimonial
                    </a>
                </h3>
                <div class="tile-body">
                    <form role="form" method="POST" action="{{route('testimonial.update')}}" name="editForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$post->id}}">
                        <div class="row">
                            <div class="col-md-8 offset-2">
                                <h6> Name</h6>
                                <div class="input-group">
                                    <input type="text" value="{{$post->name}}" class="form-control input-lg"
                                           name="name">
                                    <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-font"></i>
                                            </span>
                                    </div>
                                </div>
                                @if ($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif

                            </div>
                        </div>
                        <br>


                        <div class="row">
                            <div class="col-md-8 offset-2">
                                <h6>Image</h6>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                        @if($post->image == null)
                                            <img style="width: 200px" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=Client Image" alt="...">
                                        @else
                                            <img style="width: 120px" src="{{ asset('assets/images/testimonial') }}/{{ $post->image }}" alt="...">
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="image" accept="image/*" >
                                                </span>
                                        <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
                                </div>
                                @if ($errors->has('image'))
                                    <div class="error">{{ $errors->first('image') }}</div>
                                @endif

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 offset-2">
                                <h6>Designation</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg"
                                           name="designation" value="{{$post->designation}}">
                                    <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-font"></i>
                                            </span>
                                    </div>
                                </div>
                                @if ($errors->has('designation'))
                                    <div class="error">{{ $errors->first('designation') }}</div>
                                @endif

                            </div>
                        </div>
                        <br>



                        <div class="row">
                            <div class="col-md-8 offset-2">
                                <h6>Details</h6>
                                <textarea name="details" id="area1" cols="30" rows="6" class="form-control">{{$post->details}}</textarea>
                            </div>
                        </div>
                        <br>

                        <div class="row">

                            <div class="col-md-8 offset-2 ">
                                <button class="btn btn-primary btn-block btn-lg">Save </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('import-script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
@stop
@section('script')
@stop