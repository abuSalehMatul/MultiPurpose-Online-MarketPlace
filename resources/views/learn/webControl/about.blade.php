@extends('admin.layout.master')
@section('css')
@stop
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form class="form-horizontal" method="post" role="form">
                        {!! csrf_field() !!}
                        <div class="form-body">

                            <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                                <label class="col-md-12"><strong style="text-transform: uppercase;">About Page</strong></label>
                                <div class="col-md-12">
                                    <textarea id="area1" class="form-control" rows="15" name="about">{{ $basic->about }}</textarea>
                                    @if ($errors->has('about'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('about') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <br>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-send"></i> Update About</button>
                                </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@stop
@section('script')
<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>

<script type="text/javascript">
    bkLib.onDomLoaded(function() { new nicEditor({fullPanel : true}).panelInstance('area1'); });
</script>
@stop