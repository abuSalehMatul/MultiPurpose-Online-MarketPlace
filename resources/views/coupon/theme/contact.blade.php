@extends('coupon.layouts.theme')
@section('main-content')
<!-- contact -->
	<section id="forum" class="coupon-page-main-block">
	  <div class="container">
	    <div class="forum-page-header">
        <div class="forum-page-heading-block">
          <h5 class="forum-page-heading">Contact Us</h5>
        </div>
	    </div>
	    <!-- breadcrumb -->
	    <div id="breadcrumb" class="breadcrumb-main-block">
        <div class="breadcrumb-block">
          <ol class="breadcrumb">
            <li><a href="{{url('/')}}" title="Home">Home</a></li>
            <li class="active">Contact Us</li>
          </ol>
        </div>
	    </div>
	    <!-- breadcrumb end -->
			<div class="coupon-page-block categories-page contact-page">
				<div class="coupon-dtl-outer">
					<div class="row">
						<div class="col-lg-9 col-md-8">
							<div class="submit-deal-main-block">
								<form id="submit-deal" class="submit-deal-form contact-form" action="{{ action('PageController@contact_post') }}" method="POST">
									{{ csrf_field() }}
									<input type="hidden" name="w_email" value="info@lootcoupon.com">
									<div class="form-group">
										<label for="name">Name*</label>
										<input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Full Name" required>
									</div>
									<div class="form-group">
										<label for="store">Choose Categories</label>
										<select class="form-control" name="category" id="store" required>
											<option value="inquiry">Inquiry</option>
											<option value="feedback">Feedback</option>
											<option value="suggestions">Suggestions</option>
											<option value="coupons-issue">Coupons Issues</option>
											<option value="deal-issue">Deal Issues</option>
											<option value="forums-issue">Forums Issues</option>
											<option value="report-user">Report User</option>
											<option value="dmca">DMCA</option>
											<option value="others">Others</option>
										</select>
									</div>
									<div class="form-group">
										<label for="subject">Subject*</label>
										<input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject" required>
									</div>
									<div class="form-group">
										<label for="email">Email Address*</label>
										<input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email Address" required>
									</div>
									<div class="form-group">
										<label for="mobile">Mobile Number*</label>
										<input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile Number" required>
									</div>
	                <div class="form-group">
	                  <label for="website">Website</label>
	                  <input type="url" id="website" name="website" class="form-control" placeholder="Enter Your Website">
	                </div>
									<div class="form-group">
										<label for="message">Message</label>
										<textarea class="form-control" name="message" id="message" placeholder="Enter Your Message" required></textarea>
									</div>
									<div class="form-group">
										<div class="submit-deal-btn">
											<button type="submit" class="btn btn-primary">Submit</button>
										</div>
									</div>
								</form>
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