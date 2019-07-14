<!DOCTYPE html>
<!--
**********************************************************************************************************
    Copyright (c) 2018 .
**********************************************************************************************************  -->
<!-- 
Template Name: Stock Coupon - Responsive Coupons, Deal and Promo Template
Version: 1.0.0
Author: Media City
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]> -->
<html lang="en">
<!-- <![endif]-->
<!-- head -->
@php
	$settings=DB::table('settings')->first();
@endphp
<head>
<title>{{$settings->w_title ? $settings->w_title : ''}}</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="{{$settings->desc ? $settings->desc : ''}}" />
<meta name="keywords" content="{{$settings->keywords ? $settings->keywords : ''}}">
<meta name="author" content="Media City" />
<meta name="MobileOptimized" content="320" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/icon" href="{{asset('images/favicon/'.$settings->favicon)}}">
<!-- favicon-icon -->
<!-- theme styles -->
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/> <!-- bootstrap css -->
<link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('vendor/fontawesome/css/fontawesome-all.min.css')}}"/> <!-- fontawesome css -->
<link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.min.css')}}"/> <!-- fontawesome css -->
<link rel="stylesheet" type="text/css" href="{{asset('vendor/flaticon/flaticon.css')}}"/> <!-- flaticon css -->
<link rel="stylesheet" type="text/css" href="{{asset('vendor/owl/css/owl.carousel.min.css')}}"/> <!-- owl carousel css -->
<link rel="stylesheet" type="text/css" href="{{asset('vendor/datatables/css/responsive.datatables.min.css')}}"/> <!-- datatables responsive -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote-bs4.css"/> <!-- summernote css -->
<link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css"/> <!-- custom css -->
<script src="{{asset('coupon/js/jquery-3.3.1.min.js')}}"></script> <!-- jquery library js -->
<script>
  window.Laravel =  <?php echo json_encode([
      'csrfToken' => csrf_token(),
  ]); ?>
</script>
<!-- end theme styles -->
</head>
<!-- end head -->
<!-- body start-->
<body>
	<!-- 404 page -->
		<section id="error-404-page" class="error-404-page" style="background-image: url({{asset('images/bg/403-bg.jpg')}});">
			<div class="overlay-bg"></div>
			<div class="container">
				<div class="error-page-main-block">
				<div class="error-404-block text-center">
					<h3 class="error-heading">Oops!</h3>
					<h1 class="error-name">403</h1>
					<h3 class="error-subheading">Web Server Error</h3>
						<div class="home-btn">
							<a href="{{url('/')}}" title="Home" class="btn btn-primary">Go To Home</a>
						</div>
					</div>
					<div class="error-notify-block text-center">
						<div class="row">
							<div class="col-lg-6 ml-lg-auto mr-lg-auto col-md-10 ml-md-auto mr-md-auto">
								{!! Form::open(['method' => 'POST', 'action' => 'EmailSubscribeController@subscribe', 'id' => 'subscribe-form', 'class' => 'error-notify subscribe-form']) !!}
                	{{ csrf_field() }}
									<div class="form-group">
										<p>Subscribe to our email newsletter to stay updated</p>
										<div class="row no-gutters">
											<div class="col-md-8">
												<input type="email" id="mc-email" class="form-control" placeholder="Enter Your Email">
											</div>
											<div class="col-md-4">
												<button type="submit" class="btn btn-primary">Subscribe</button>
											</div>
										</div>
										<label for="mc-email"></label>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
					</div>	
				</div>	
			</div>
		</section>
	<!-- end 404 page -->
<!-- jquery -->
<script src="{{asset('coupon/js/bootstrap.bundle.min.js')}}"></script> <!-- bootstrap js -->
<script src="{{asset('coupon/vendor/owl/js/owl.carousel.min.js')}}"></script> <!-- owl carousel js -->
<script src="{{asset('coupon/vendor/mailchimp/jquery.ajaxchimp.min.js')}}"></script> <!-- mailchimp js -->
<script src="{{asset('coupon/vendor/datatables/js/jquery.datatables.min.js')}}"></script> <!-- datatables bootstrap js -->		
<script src="{{asset('coupon/vendor/datatables/js/datatables.responsive.min.js')}}"></script> <!-- datatables bootstrap js -->		
<script src="{{asset('coupon/vendor/datatables/js/datatables.min.js')}}"></script> <!-- datatables bootstrap js -->		
<script src="{{asset('coupon/vendor/summernote/js/summernote-bs4.min.js')}}"></script> <!-- summernote js -->
<script src="{{asset('coupon/js/theme.js')}}"></script> <!-- custom js -->
@yield('custom-scripts')
<script>
@if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
$(function() {
    $('#login').modal('show');
});
@endif
@if (count($errors) > 0)
    $('#login').modal('show');
@endif
</script>
<!-- end jquery -->
</body>
<!-- body end -->
</html>