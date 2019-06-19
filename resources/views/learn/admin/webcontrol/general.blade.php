@extends('admin.layout.master')

@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title ">{{$page_title}}</h3>
                <div class="tile-body">
                    <form role="form" method="POST" action="">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <h6>Website Title</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" value="{{$general->sitename}}"
                                           name="sitename">
                                    <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-file-text-o"></i>
                                            </span>
                                    </div>
                                </div>
                                <span class="text-danger">{{$errors->first('sitename')}}</span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <h6>Website Short Heading</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" value="{{$general->short_heading}}"
                                           name="short_heading">
                                    <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-file-text-o"></i>
                                            </span>
                                    </div>
                                </div>
                                <span class="text-danger">{{$errors->first('short_heading')}}</span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <h6>Website Short Notes</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" value="{{$general->short_notes}}"
                                           name="short_notes">
                                    <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-file-text-o"></i>
                                            </span>
                                    </div>
                                </div>
                                <span class="text-danger">{{$errors->first('short_notes')}}</span>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <h6>Site Color</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" style="background-color: #{{$basic->color}} " value="{{$general->color}}"
                                           name="color">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-paint-brush"></i>
                                        </span>
                                    </div>
                                </div>
                                <span class="text-danger">{{ $errors->first('color') }}</span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <h6>Category Circle Color</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" style="background-color: #{{$basic->color2}} " value="{{$general->color2}}"
                                           name="color2">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-paint-brush"></i>
                                        </span>
                                    </div>
                                </div>
                                <span class="text-danger">{{ $errors->first('color2') }}</span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <h6>Category Circle Hover Color</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" style="background-color: #{{$basic->hover}} " value="{{$general->hover}}"
                                           name="hover">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-paint-brush"></i>
                                        </span>
                                    </div>
                                </div>
                                <span class="text-danger">{{ $errors->first('hover') }}</span>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <h6>EMAIL NOTIFICATION</h6>
                                <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                       data-width="100%" type="checkbox"
                                       name="email_notification" {{ $general->email_notification == "1" ? 'checked' : '' }}>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10 offset-md-1 ">
                                <button class="btn btn-primary btn-block btn-lg">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

@stop