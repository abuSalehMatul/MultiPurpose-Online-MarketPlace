@extends('learn.admin.layout.master')
@section('body')
	<div class="row">
		<div class="col-md-12">
			<div class="tile">
				<div class="tile-body">
					@foreach($service->chunk(2) as $data)
						<div class="row">
							@foreach($data as $m)
								<div class="col-md-6 text-center">
									<img src="{{asset('learn/assets/images/'.$m->image)}}" alt="image">
									<h2 class="bold">{{$m->title}}</h2>
									<p>
										{!! $m->details !!}
									</p>
									<a href="{{ route('service-edit',$m->id) }}"
									   class="btn btn-primary btn-block"><i class="fa fa-edit"></i> Edit </a>
								</div>
							@endforeach
						</div>
						<br><br>
					@endforeach
				</div>
			</div>
		</div>
	</div>

@stop

@section('script')

@stop