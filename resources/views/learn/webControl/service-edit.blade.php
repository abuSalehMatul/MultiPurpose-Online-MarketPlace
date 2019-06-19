@extends('admin.layout.master')
@section('css')

@stop
@section('body')
	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<div class="tile-body">
					<form class="form-horizontal" action="{{ route('service-update',$service->id) }}" method="post" role="form" enctype="multipart/form-data">

						{!! csrf_field() !!}
						<div class="form-body">


							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail"
									 style="width: 200px; height: 150px;"
									 data-trigger="fileinput">
									<img style="width: 120px"
										 src="{{asset('assets/images/'.$service->image)}}"
										 alt="...">

								</div>
								<div class="fileinput-preview fileinput-exists thumbnail"
									 style="max-width: 200px; max-height: 150px"></div>

								<div class="img-input-div">
                                                <span class="btn btn-primary btn-file">
                                                    <span class="fileinput-new bold uppercase"><i
																class="fa fa-file-image-o"></i> Select Thumbnail </span>
                                                    <span class="fileinput-exists bold uppercase"><i
																class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="image" class="{{ $errors->has('image') ? ' is-invalid' : '' }}" accept="image/*">
                                                </span>
									<a href="#" class="btn btn-danger fileinput-exists bold uppercase"
									   data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
								</div>
							</div>

							@if ($errors->has('image'))
								<span class="invalid-feedback error-color red">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
							@endif




							<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
								<label class="col-md-12"><strong style="text-transform: uppercase;">Title</strong></label>
								<div class="col-md-12">
									<input class="form-control input-lg" value="{{ $service->title }}" name="title" placeholder="" type="text" >
									@if ($errors->has('title'))
										<span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('details') ? ' has-error' : '' }}">
								<label class="col-md-12"><strong style="text-transform: uppercase;">Details</strong></label>
								<div class="col-md-12">
									<input class="form-control input-lg" value="{{ $service->details }}" name="details" placeholder="" type="text" >
									@if ($errors->has('details'))
										<span class="help-block">
                                            <strong>{{ $errors->first('details') }}</strong>
                                        </span>
									@endif
								</div>
							</div>

							<br>
							<div class="row">
								<div class="col-md-12">
									<button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-send"></i> UPDATE </button>
								</div>
							</div>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>





@stop

@section('script')

@stop