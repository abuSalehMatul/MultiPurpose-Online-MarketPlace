@extends('admin.layout.master')
@section('import-css')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    {!! Form::model($basic,['route'=>['manage-footer-update'],'method'=>'PUT','role'=>'form','class'=>'form-horizontal','files'=>true]) !!}

                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group{{ $errors->has('goal_heading') ? ' has-error' : '' }}">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Our Goal Heading</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="goal_heading" id="area1" class="form-control" required>{{ $basic->goal_heading }}</textarea>
                                        @if ($errors->has('goal_heading'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('goal_heading') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('goal_para') ? ' has-error' : '' }}">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Our Goal Short Notes</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="goal_para" id="area1" class="form-control" required>{{ $basic->goal_para }}</textarea>
                                        @if ($errors->has('goal_para'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('goal_para') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('breadcrumb_text') ? ' has-error' : '' }}">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Website Short Info</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="breadcrumb_text" id="area1" class="form-control" required>{{ $basic->breadcrumb_text }}</textarea>
                                        @if ($errors->has('breadcrumb_text'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('breadcrumb_text') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-send"></i> UPDATE</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- row -->

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@stop

@section('import-script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
@stop