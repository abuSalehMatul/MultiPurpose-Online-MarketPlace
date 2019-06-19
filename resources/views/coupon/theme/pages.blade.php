@extends('coupon.layouts.theme')
@section('main-content')
<!-- Page -->
	<section id="about" class="coupon-page-main-block">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">{{$pages->title}}</h5>
				</div>
				<!-- breadcrumb -->
				<div id="breadcrumb" class="breadcrumb-main-block">
					<div class="breadcrumb-block">
						<ol class="breadcrumb">
							<li><a href="{{url('/')}}" title="Home">Home</a></li>
							<li class="active">{{$pages->title}}</li>
						</ol>
					</div>
				</div>
				<!-- breadcrumb end -->
			</div>
			<div class="about-us-page">
				<div class="coupon-dtl-outer">
					<div class="row">
						<div class="col-lg-9 col-md-8">
							<div class="about-us-main-block page-block">
								<div class="about-section">
									{!! $pages->body !!}
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-4">
							<div class="coupon-sidebar">
      					@include('coupon.includes.side-bar')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<!-- end forum -->
@endsection