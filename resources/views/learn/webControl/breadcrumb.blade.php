@extends('learn.admin.layout.master')
@section('import-css')
    <link href="{{ asset('learn/assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@stop
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <form action="" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}


                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Change
                                            Testimonial</strong></label>
                                    <div class="col-sm-12">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="input-group input-large">
                                                <div class="form-control uneditable-input input-fixed input-medium"
                                                     data-trigger="fileinput">
                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                    <span class="fileinput-filename"> </span>
                                                </div>
                                                <span class="input-group-addon btn btn-success btn-file">
                                                                    <span class="fileinput-new  bold"> Change Testimonial </span>
                                                                    <span class="fileinput-exists bold"> Change </span>
                                                                    <input type="file" name="testimonial"> </span>
                                                <a href="javascript:;" style="margin-left: 5px"
                                                   class="input-group-addon btn btn-danger fileinput-exists"
                                                   data-dismiss="fileinput"> Remove </a>
                                            </div>
                                            <code>Testimonial Image Type : jpg </code>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <img class="img-responsive" src="{{ asset('learn/assets/images/logo/testimonial.jpg') }}"
                                     alt="logo" width="100%">
                            </div>
                        </div>




                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary bold btn-block"><i
                                                class="fa fa-send"></i> UPDATE
                                    </button>
                                </div>
                            </div>

                    </form>


                </div>
            </div>
        </div>
    </div>


@stop

@section('import-script')
    <script src="{{ asset('learn/assets/admin/js/bootstrap-fileinput.js') }}"></script>
@stop