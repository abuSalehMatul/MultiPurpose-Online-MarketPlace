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
<link rel="icon" type="image/icon" href="{{asset('coupon/images/favicon/'.$settings->favicon)}}"> 
<!-- favicon-icon -->
<!-- theme styles -->
<link href="{{asset('coupon/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/> 
<!-- bootstrap css -->
<link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('coupon/vendor/fontawesome/css/fontawesome-all.min.css')}}"/> 
<!-- fontawesome css -->
<link rel="stylesheet" type="text/css" href="{{asset('coupon/css/font-awesome.min.css')}}"/> 
<!-- fontawesome css -->
<link rel="stylesheet" type="text/css" href="{{asset('coupon/vendor/flaticon/flaticon.css')}}"/> <!-- flaticon css -->
<link rel="stylesheet" type="text/css" href="{{asset('coupon/vendor/owl/css/owl.carousel.min.css')}}"/> 
<!-- owl carousel css -->
<link rel="stylesheet" type="text/css" href="{{asset('coupon/vendor/datatables/css/responsive.datatables.min.css')}}"/> 
<!-- datatables responsive -->
<link href="{{asset('coupon/css/jquery.rateyo.css')}}" rel="stylesheet" type="text/css"/> 
<!-- rateyo css -->
<link href="{{asset('coupon/vendor/datepicker/datepicker.css')}}" rel="stylesheet" type="text/css" />
<!-- datepicker css -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote-bs4.css"/> <!-- summernote css -->
<link href="{{asset('coupon/css/summernote-bs4.css')}}" rel="stylesheet" type="text/css" />
<!-- summernote css -->
<link href="{{asset('coupon/css/select2.css')}}" rel="stylesheet" type="text/css"/> 
<!-- select css -->
<link href="{{asset('coupon/css/style.css')}}" rel="stylesheet" type="text/css"/> 
<!-- custom css -->
<script src="{{asset('coupon/js/jquery-3.3.1.min.js')}}"></script> 
<!-- jquery library js -->
<script>
  window.Laravel =  <?php echo json_encode([
      'csrfToken' => csrf_token(),
  ]); ?>
</script>
<script>
	$( document ).ready(function() {
		@if(Route::currentRouteName() != 'register' && Route::currentRouteName() != 'login' && (count($errors) > 0) && ($errors->has('email1') || $errors->has('password1'))) 
    	$('#register').modal('show');
		@elseif((Route::currentRouteName() != 'login' && Route::currentRouteName() != 'register') && (count($errors) > 0) && (!empty(Session::get('error_code')) && Session::get('error_code') == 5) || ($errors->has('email') || $errors->has('password')))
    	$('#login').modal('show');
    @endif
	});
</script>
<!-- end theme styles -->
</head>
<!-- end head -->
<!-- body start-->
<body>

	<div>
		@include('flash::message')
	</div>
	@if($settings->preloader == 1)
		<!-- preloader --> 
	  <div class="preloader">
	      <div class="status">
	          <div class="status-message">
	          </div>
	      </div>
	  </div>
	@endif
  <!-- end preloader -->
  <!-- topbar -->
	<section id="top-bar" class="top-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-4 d-none d-sm-block">
					@if(isset($social) && count($social)>0)
						<div class="social-icon">
							<ul>
								@foreach($social as $item)
									<li class="{{strtolower($item->title)}}-icon"><a href="{{$item->url}}" target="_blank" title="{{$item->title}}"><i class="{{$item->icon}}"></i></a></li>
								@endforeach
							</ul>
						</div>
					@endif
				</div>
				<div class="col-md-6 col-sm-8">
					<div class="top-nav">
						<ul>
							@if(Auth::check())
								<li><a href="{{ url('user/account') }}" class="user-acc" title="My Account"><i class="far fa-user"></i> {{strtok(auth()->user()->first_name,' ')}}</a></li>
								<li><a href="{{ route('logout') }}"
									onclick="event.preventDefault();
											 document.getElementById('logout-form').submit();">
									Logout
								</a></li>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
								</form>
								<li class="search-icon"><a href="#" title="Search"><i class="fas fa-search"></i></a></li>
							@else  
								<li><i class="flaticon-login"></i><a href="{{url('login')}}"  title="Login">Login</a></li>
								<li><i class="flaticon-register"></i><a href="{{url('register')}}" title="Register">Register</a></li>
								<li class="search-icon"><a href="#" title="Search"><i class="fas fa-search"></i></a></li>
							@endif
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- search -->
		<div class="search">
			<div class="container clearfix">
				{!! Form::open(['method' => 'GET', 'action' => 'SearchController@homeSearch', 'class' => 'forum-search']) !!}
					<input type="search" name="search" class="search-box" placeholder="Type anything here...." />
					<a href="#" class="fa fa-times search-close"></a>
				{!! Form::close() !!}
			</div>
		</div>
		<!-- end search -->
	</section>
	<!-- end topbar -->
	<!-- login -->
	<div class="modal fade login-form-main" id="login" tabindex="-1" role="dialog" aria-labelledby="loginLongTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content text-center">
	      <div class="login-header">
	        <h5 class="login-title" id="loginLongTitle">Login</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true" class="close-btn">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<form method="POST" action="{{ route('login') }}" class="login-form">
	      		{{ csrf_field() }}
	      		<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	      			<input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
	      			@if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
	      		</div>
	      		<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	      			<input type="password" class="form-control" name="password" placeholder="Password" required>
	      			@if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
	      		</div>
	      		<div class="form-group">
	      			<div class="row">
	      				<div class="col-md-6 text-left">
	      					{{-- <div class="form-check">
								    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
								    <label class="form-check-label" for="remember">Remember Me</label>
								  </div> --}}
	      				</div>
	      				<div class="col-md-6 text-right">
	      					<a href="{{ route('password.request') }}" title="Forgot Password?">Forgot Password?</a>
	      				</div>
	      			</div>
	      		</div>
	      		<div class="form-group">
	      			<button type="submit" class="btn btn-primary">Login</button>
	      		</div>
	      		<div class="or-text">Or</div>
	      		<div class="form-group">
		      		<div class="row">
		      			<div class="col-md-6">
		      				<div class="form-group">
				      			<a href="{{ url('/auth/facebook') }}" class="btn btn-primary fb-btn" title="Login With Facebook"><i class="fab fa-facebook-f"></i>Login With Facebook</a>
				      		</div>
		      			</div>
		      			<div class="col-md-6">
		      				<div class="form-group">
				      			<a href="{{ url('/auth/google') }}" class="btn btn-primary gplus-btn" title="Login With Google"><i class="fab fa-google"></i>Login With Google</a>
				      		</div>
		      			</div>
		      		</div>
		      	</div>
	      		<div class="form-group flip-modal">
	      			<a href="" data-toggle="modal" data-target="#register" title="Register" data-dismiss="modal" aria-label="Close">Don't have an account? Register Now</a>
	      		</div>
	      	</form>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- end login -->
	<!-- register -->
	<div class="modal fade login-form-main register-form-main" id="register" tabindex="-1" role="dialog" aria-labelledby="RegisterLongTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content text-center">
	      <div class="login-header">
	        <h5 class="login-title" id="RegisterLongTitle">Register</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true" class="close-btn">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<form method="POST" action="{{ route('register') }}" class="login-form" id="register-form">
	      		<input type="hidden" name="_token" value="{{csrf_token()}}">
	      		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	      			<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required>
	      			@if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
            	@endif
	      		</div>
	      		<div class="form-group{{ $errors->has('email1') ? ' has-error' : '' }}">
	      			<input type="email" class="form-control" name="email1" value="{{ old('email1') }}" placeholder="Email" required>
	      				@if ($errors->has('email1'))
									<span class="help-block">
										<strong>{{ $errors->first('email1') }}</strong>
									</span>
								@endif
	      		</div>
	      		<div class="form-group{{ $errors->has('password1') ? ' has-error' : '' }}">
	      			<input type="password" class="form-control" name="password1" placeholder="Password" required>
	      			  @if ($errors->has('password1'))
									<span class="help-block">
										<strong>{{ $errors->first('password1') }}</strong>
									</span>
								@endif
	      		</div>
	      		<div class="form-group">
	      			<input type="password" class="form-control" name="password1_confirmation" placeholder="Confirm Password" required>
	      		</div>
	      		<div class="form-group">
	      			<button type="submit" class="btn btn-primary">Register</button>
	      		</div>
	      		<div class="or-text">Or</div>
	      		<div class="form-group">
	      			<div class="row">
		      			<div class="col-md-6">
		      				<div class="form-group">
				      			<a href="{{ url('/auth/facebook') }}" class="btn btn-primary fb-btn" title="Register With Facebook"><i class="fab fa-facebook-f"></i>Register With Facebook</a>
				      		</div>
		      			</div>
		      			<div class="col-md-6">
		      				<div class="form-group">
				      			<a href="{{ url('/auth/google') }}" class="btn btn-primary gplus-btn" title="Register With Google"><i class="fab fa-google"></i>Register With Google</a>
				      		</div>
		      			</div>
		      		</div>
	      		</div>
	      		<div class="form-group flip-modal">
	      			<a href="" data-toggle="modal" data-target="#login" title="Register" data-dismiss="modal" aria-label="Close">Already have an account? Login Now</a>
	      		</div>
	      	</form>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- end register -->
	<!-- logo -->
	<section class="logo-block">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-4">
					<div class="logo">
						@if($settings->logo != Null)
							<a href="{{url('/')}}" title="Home"><img src="{{asset('coupon/images/'.$settings->logo)}}" class="img-fluid" alt="Logo"></a>
						@else
							<h2 class="logo-title">{{$settings->w_name ? $settings->w_name : 'Logo'}}</h2>
						@endif
					</div>
				</div>
				<div class="col-lg-7 ml-lg-auto col-md-8 d-none d-md-block d-lg-block text-right">
					<div class="top-ad">
						<a href="#" title="Advertisement"><img src="{{$settings->navbar_img ? asset('coupon/images/'.$settings->navbar_img) : asset('coupon/images/ads/ad-01.jpg')}}" class="img-fluid" alt="Advertisement"></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end logo -->
	<!-- navbar -->
	<section class="navbar">
		<div class="container">
			<nav class="navbar navbar-expand-lg">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav">
			      <li class="nav-item">
			        <a class="nav-link {{ Nav::isRoute('home') }}" href="{{url('/')}}">Home</a>
			      </li>
			      <li class="nav-item dropdown nav-dropdown">
			        <a class="nav-link dropdown-toggle {{ Nav::urlDoesContain('/coupon-dtl') }}" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			          Coupons
			        </a>
			        <div class="dropdown-menu nav-dropdown-menu mega-menu mega-menu-two" aria-labelledby="navbarDropdown2">
		            <div class="row">
		            	<div class="col-md-3 submenu-two">
		            		<div class="submenu-links first-submenu">
		            			@if(isset($store_list) && count($store_list)>0)
			            			<ul>
			            				@foreach($store_list->take(9) as $item)
			            					<li><a href="{{url('coupon-dtl/'.$item->slug)}}" title="{{$item->title}}">{{$item->title}}</a></li>
			            				@endforeach
		            					<li class="submenu-all"><a href="{{url('coupon')}}" title="View All">View All</a></li>
			            			</ul>
			            		@endif
		            		</div>
		            	</div>
		            	@if(isset($f_coupon) && count($f_coupon)>0)
			            	<div class="col-md-9 d-none d-md-block d-lg-block">
			            		<div class="submenu-links menu-deal-block-main">
			            			<h6 class="menu-heading">Featured Coupons</h6>
		            				<div id="menu-deal-slider" class="menu-deal-slider owl-carousel">
		            					@foreach($f_coupon->take(10) as $item)
			            					<div class="deal-block menu-deal-block">
															<div class="deal-img">
																<a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" title="{{$item->title}}"><img src="{{asset('coupon/images/coupon/'.$item->image)}}" class="img-fluid" alt="Deal"></a>
															</div>
															<div class="deal-dtl text-center">
																<h6 class="deal-title"><a href="{{url('post/'.$item->uni_id.'/'.$item->slug)}}" title="{{$item->title}}">{{str_limit($item->title, 40)}}</a></h6>
																<div class="deal-price-block">
																	<div class="deal-price">
																		@if($item->price)
																			<i class="{{$settings->currency}}" aria-hidden="true"></i> {{$item->price}}
																		@endif
																	</div>
																	<div class="deal-btn">
																		<a href="{{$item->link != Null ? $item->link : $item->store->link}}" title="Grab Now" class="btn btn-primary">Grab Now</a>
																	</div>
																</div>
															</div>
														</div>
													@endforeach
		            				</div>
			            		</div>
			            	</div>
			            @endif
		            </div> 
			        </div>
			      </li>
			      <li class="nav-item dropdown nav-dropdown">
			        <a class="nav-link dropdown-toggle {{ Nav::urlDoesContain('/deal-dtl') }}" href="#" id="navbarDropdown4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			          Crazy Deals
			        </a>
			        <div class="dropdown-menu mega-menu mega-menu-links nav-dropdown-menu" aria-labelledby="navbarDropdown4">
		            <div class="submenu-dtl">
		            	<div class="row">
				          	@if(isset($store_list) && count($store_list)>0)
		            			@foreach($store_list->take(19) as $key => $item)
			            			<div class="col-md-3">
			            				<div class="submenu-links-mega">
			            					<a href="{{url('deal-dtl/'.$item->slug)}}" title="{{$item->title}}">{{$item->title}}</a>
			            				</div>
			            			</div>
			            		@endforeach
			            	@endif
			            	<div class="col-md-3">
			            		<div class="submenu-links-mega submenu-all">
			            			<a href="{{url('deal')}}" title="View All">View All</a>
			            		</div>
			            	</div>
			            </div>
			          </div>
			        </div>
			      </li>
			      <li class="nav-item dropdown nav-dropdown">
							<a class="nav-link dropdown-toggle {{ Nav::urlDoesContain('/category-dtl') }}" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						  Categories
							</a>
							<div class="dropdown-menu mega-menu mega-menu-links nav-dropdown-menu" aria-labelledby="navbarDropdown1">
	            <div class="submenu-dtl">
	            	<div class="row">
			          	@if(isset($category_list) && count($category_list)>0)
	            			@foreach($category_list->take(19) as $key => $item)
		            			<div class="col-md-3">
		            				<div class="submenu-links-mega">
		            					<a href="{{url('category-dtl/'.$item->slug)}}" title="{{$item->title}}">{{strtok($item->title,' ')}}</a>
		            				</div>
		            			</div>
		            		@endforeach
		            	@endif
		            	<div class="col-md-3">
		            		<div class="submenu-links-mega submenu-all">
		            			<a href="{{url('category')}}" title="View All">View All</a>
		            		</div>
		            	</div>
		            </div>
		          </div>
			      </li>
			      <li class="nav-item">
			       	@auth
			        	<a class="nav-link {{ Nav::urlDoesContain('/submit') }}" href="{{url('submit')}}">Submit Deals</a>
			        @else
			        	<a class="nav-link {{ Nav::urlDoesContain('/submit') }}" href="{{url('login')}}" >Submit Deals</a>
			        @endauth
			      </li>
			      <li class="nav-item">
			        <a class="nav-link {{ Nav::isRoute('blog') }}" href="{{url('blog')}}">Blogs</a>
			      </li>
			      <li class="nav-item dropdown nav-dropdown">
			        <a class="nav-link dropdown-toggle {{ Nav::urlDoesContain('/forum-dtl') }}" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			          Forums
			        </a>
			        <div class="dropdown-menu single-menu nav-dropdown-menu" aria-labelledby="navbarDropdown3">
			          <div class="submenu-links first-submenu">
			          	@if(isset($forumcategory_list) && count($forumcategory_list)>0)
	            			<ul>
	            				@foreach($forumcategory_list->take(3) as $item)
		            				<li><a href="{{url('forum-dtl/'.$item->slug)}}" title="{{$item->title}}">{{$item->title}}</a></li>
		            			@endforeach
		            			<li class="submenu-all"><a href="{{url('forum')}}" title="View All Forums">View All Forums</a></li>
            				</ul>
            			@endif
            		</div>
			        </div>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link {{ Nav::isRoute('contact_coupon') }}" href="{{url('contact_coupon')}}">Contact Us</a>
			      </li>
			    </ul>
			  </div>
			</nav>
		</div>
	</section>
	<!-- end navbar -->	
	@yield('main-content')
	<!-- footer start -->
	<footer id="footer" class="footer-main-block">
	  <div style="height: 0px">
	  	<a id="back2Top" title="Back to top" href="#">&#10148;</a>
	  </div>
		@if($settings->footer_layout == 1)
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-6">
						<div class="footer-widget link-widget">
							<h6 class="footer-widget-heading">{{$settings->f_title1}}</h6>
	            @if(isset($f_menu))	
								<ul>
									@foreach($f_menu as $item)														
		            		@if($item->widget == '1')	
											<li><a href="{{url($item->slug)}}" target="_blank" title="{{$item->title}}">{{$item->title}}</a></li>
										@endif
									@endforeach
								</ul>
							@endif
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="footer-widget link-widget">
							<h6 class="footer-widget-heading">{{$settings->f_title2}}</h6>
							@if(isset($f_menu))	
								<ul>
									@foreach($f_menu as $item)														
		            		@if($item->widget == '2')	
											<li><a href="{{url($item->slug)}}" target="_blank" title="{{$item->title}}">{{$item->title}}</a></li>
										@endif
									@endforeach
								</ul>
							@endif
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="footer-widget link-widget">
							<h6 class="footer-widget-heading">{{$settings->f_title3}}</h6>
							@if(isset($f_menu))	
								<ul>
									@foreach($f_menu as $item)														
		            		@if($item->widget == '3')	
											<li><a href="{{url($item->slug)}}" target="_blank" title="{{$item->title}}">{{$item->title}}</a></li>
										@endif
									@endforeach
								</ul>
							@endif
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="footer-widget footer-subscribe">				
							<h6 class="footer-widget-heading">{{$settings->f_title4}}</h6>
							@if(isset($settings) && $settings->is_mailchimp)		
								<p>{{$settings->m_text}}</p>
								{!! Form::open(['method' => 'POST', 'action' => 'EmailSubscribeController@subscribe', 'id' => 'subscribe-form', 'class' => 'subscribe-form']) !!}
	              	{{ csrf_field() }}
									<div class="row no-gutters">
										<div class="col-md-9">
											<div class="form-group">
				                <label class="sr-only">Your Email address</label>
				                <input type="email" class="form-control" id="mc-email" placeholder="Enter email address">
				              </div>
										</div>
										<div class="col-md-3">
											<button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			              	<label for="mc-email"></label>
										</div>
									</div>
	              {!! Form::close() !!}
	            @endif
	            @if(isset($settings) && $settings->is_playstore)
		            <div class="app-badge play-badge">
		            	<a href="{{$settings->playstore_link}}" target="_blank" title="Google Play"><img src="{{asset('coupon/images/google-play.png')}}" class="img-fluid" alt="Google Play"></a>
		            </div>
		          @endif
		          @if(isset($settings) && $settings->is_app_icon)
		            <div class="app-badge">
		            	<a href="{{$settings->app_link}}" target="_blank" title="Apple App Store"><img src="{{asset('coupon/images/app-store.png')}}" class="img-fluid" alt="Apple App Store"></a>
		            </div>
		          @endif
						</div>
					</div>
				</div>
				<div class="border-divider">
				</div>
				<div class="copyright">
					<div class="row">
						<div class="col-md-6">
							<div class="copyright-text">
				  			<p>&copy; <?php echo date("Y"); ?><a href="{{url('/')}}" title="{{$settings->w_name}}"> {{$settings->w_name}}</a> | {{$settings->copyright}}</p>
			        </div>
						</div>
						<div class="col-md-6">
							@if(isset($social) && count($social)>0)
							<div class="social-icon">
								<ul>
									@foreach($social as $item)
										<li class="{{strtolower($item->title)}}-icon"><a href="{{$item->url}}" target="_blank" title="{{$item->title}}"><i class="{{$item->icon}}"></i></a></li>
									@endforeach
								</ul>
							</div>
						@endif
						</div>
					</div>
		    </div>
			</div>
		@else
			<div class="container footer2 ">
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<div class="footer-widget footer-subscribe">
							<div class="logo">
								@if($settings->footer_logo != Null)
									<a href="{{url('/')}}" title="Home"><img src="{{asset('coupon/images/'.$settings->footer_logo)}}" class="img-fluid" alt="Footer Logo"></a>
								@else
									<h2 class="logo-title" style="color:#FFF;">{{$settings->w_name ? $settings->w_name : 'Logo'}}</h2>
								@endif
							</div>
							<p>{{$settings->footer_text ? $settings->footer_text : ''}}</p>
							@if(isset($settings) && $settings->is_mailchimp)
								<p>{{$settings->m_text}}</p>	
								{!! Form::open(['method' => 'POST', 'action' => 'EmailSubscribeController@subscribe', 'id' => 'subscribe-form', 'class' => 'subscribe-form']) !!}
	              	{{ csrf_field() }}
									<div class="row no-gutters">
										<div class="col-md-9">
											<div class="form-group">
				                <label class="sr-only">Your Email address</label>
				                <input type="email" class="form-control" id="mc-email" placeholder="Enter email address">
				              </div>
										</div>
										<div class="col-md-3">
											<button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			              	<label for="mc-email"></label>
										</div>
									</div>
	              {!! Form::close() !!}	
	            @endif
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="footer-widget link-widget">
							<h6 class="footer-widget-heading">{{$settings->f_title2}}</h6>
							@if(isset($f_menu))	
								<ul>
									@foreach($f_menu as $item)														
		            		@if($item->widget == '2')	
											<li><a href="{{url($item->slug)}}" target="_blank" title="{{$item->title}}">{{$item->title}}</a></li>
										@endif
									@endforeach
								</ul>
							@endif
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="footer-widget link-widget">
							<h6 class="footer-widget-heading">{{$settings->f_title3}}</h6>
							@if(isset($f_menu))	
								<ul>
									@foreach($f_menu as $item)														
		            		@if($item->widget == '3')	
											<li><a href="{{url($item->slug)}}" target="_blank" title="{{$item->title}}">{{$item->title}}</a></li>
										@endif
									@endforeach
								</ul>
							@endif
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="footer-widget app-widget">
							<h6 class="footer-widget-heading">{{$settings->f_title4}}</h6>
							@if($settings->w_address)
								<ul class="contact-widget-dtl">                   
								  <li><i class="fas fa-map-marker"></i></li>
								  <li>{{$settings->w_address}}</li>
								</ul>
							@endif
							@if($settings->w_address)
								<ul class="contact-widget-dtl">  
								  <li><i class="fas fa-phone"></i></li>		
								  <li><a href="tel:{{$settings->w_phone}}">{{$settings->w_phone}}</a></li>
								</ul>
							@endif
							@if($settings->w_address)
								<ul class="contact-widget-dtl">  
								  <li><i class="fas fa-envelope"></i></li>
								  <li><a href="mailto:{{$settings->w_email}}?Subject=Hello%20again" target="_top">{{$settings->w_email}}</a></li>	
								</ul>
							@endif	
							@if($settings->w_time)
								<ul class="contact-widget-dtl">  
								  <li><i class="fas fa-clock"></i></li>
								  <li>{{$settings->w_time}}</li>	
								</ul>
							@endif
						</div>
					</div>
				</div>
				<div class="border-divider">
				</div>
				<div class="copyright">
					<div class="row">
						<div class="col-md-4">
							<div class="copyright-text">
				  			<p>&copy; <?php echo date("Y"); ?><a href="{{url('/')}}" title="{{$settings->w_name}}"> {{$settings->w_name}}</a> | {{$settings->copyright}}</p>
			        </div>
						</div>
						<div class="col-md-4">
							<div class="footer2-icon text-center">
								<ul>
									<li>
										@if(isset($settings) && $settings->is_playstore)
					            <div class="app-badge play-badge">
					            	<a href="{{$settings->playstore_link}}" target="_blank" title="Google Play"><img src="{{asset('coupon/images/google-play.png')}}" class="img-fluid" alt="Google Play"></a>
					            </div>
					          @endif
					        </li>
					        <li>
					          @if(isset($settings) && $settings->is_app_icon)
					            <div class="app-badge">
					            	<a href="{{$settings->app_link}}" target="_blank" title="Apple App Store"><img src="{{asset('coupon/images/app-store.png')}}" class="img-fluid" alt="Apple App Store"></a>
					            </div>
					          @endif
					        </li>
					      </ul>
			        </div>
			      </div>
						<div class="col-md-4">
							@if(isset($social) && count($social)>0)
							<div class="social-icon">
								<ul>
									@foreach($social as $item)
										<li class="{{strtolower($item->title)}}-icon"><a href="{{$item->url}}" target="_blank" title="{{$item->title}}"><i class="{{$item->icon}}"></i></a></li>
									@endforeach
								</ul>
							</div>
						@endif
						</div>
					</div>
		    </div>
			</div>
		@endif
	</footer>
	<!-- footer end -->
<!-- jquery -->
<script src="{{asset('coupon/js/bootstrap.bundle.min.js')}}"></script> 
<!-- bootstrap js -->
<script src="{{asset('coupon/js/select2.js')}}"></script> 
<!-- select2 js --> 
<script src="{{asset('coupon/vendor/owl/js/owl.carousel.min.js')}}"></script> 
<!-- owl carousel js -->
<script src="{{asset('coupon/vendor/mailchimp/jquery.ajaxchimp.min.js')}}"></script> 
<!-- mailchimp js -->
<script src="{{asset('coupon/vendor/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- bootstrap datepicker js-->
<script src="{{asset('coupon/vendor/datatables/js/jquery.datatables.min.js')}}"></script> 
<!-- datatables bootstrap js -->		
<script src="{{asset('coupon/vendor/datatables/js/datatables.responsive.min.js')}}"></script> <!-- datatables bootstrap js -->		
<script src="{{asset('coupon/vendor/datatables/js/datatables.min.js')}}"></script> 
<!-- datatables bootstrap js -->
<script src="{{asset('coupon/vendor/summernote/js/summernote-bs4.min.js')}}"></script>
<!-- summernote js -->
<script src="{{asset('coupon/vendor/clipboard/js/clipboard.min.js')}}"></script>
<!-- clipboard js -->
<script src="{{asset('coupon/js/jquery.rateyo.js')}}"></script> 
<!-- Rateyo js --> 
<script src="{{asset('coupon/js/theme.js')}}"></script> 
<!-- custom js -->
@yield('custom-scripts')
<script>
$(document).ready(function(){$(".grab-now").click(function(){var n=$(this).data("id");console.log(n),$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},type:"GET",url:"{{ url('counter') }}",data:{id:n},error:function(n,o,t){console.log(n)}})})});
</script>
@if($settings->right_click == 1)
  <script type="text/javascript" language="javascript">
   // Right click disable 
    $(function() {
	    $(this).bind("contextmenu", function(inspect) {
	    	inspect.preventDefault();
	    });
    });
      // End Right click disable 
  </script>
@endif
@if($settings->inspect == 1)
<script type="text/javascript" language="javascript">
//all controller is disable 
  $(function() {
	  var isCtrl = false;
	  document.onkeyup=function(e){
		  if(e.which == 17) isCtrl=false;
		}
		document.onkeydown=function(e){
		  if(e.which == 17) isCtrl=true;
		  if(e.which == 85 && isCtrl == true) {
			  return false;
			}
	  };
    $(document).keydown(function (event) {
      if (event.keyCode == 123) { // Prevent F12
        return false;
  		} 
      else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I
	     	return false;
	   	}
 		});  
	});
  // end all controller is disable 
 </script>
@endif
@if($settings->is_gotop==1)
	<script type="text/javascript">
	 //Go to top
	$(window).scroll(function() {
	  var height = $(window).scrollTop();
	  if (height > 100) {
	      $('#back2Top').fadeIn();
	  } else {
	      $('#back2Top').fadeOut();
	  }
	});
	$(document).ready(function() {
	  $("#back2Top").click(function(event) {
	      event.preventDefault();
	      $("html, body").animate({ scrollTop: 0 }, "slow");
	      return false;
	  });
	});
	// end go to top 
	</script>
@endif
<!-- Add Qulink script Here -->
<!-- end jquery -->
</body>	
<!-- body end -->
</html>

