<?php $__env->startSection('main-content'); ?>
	<!-- profile -->
	<section id="forum" class="coupon-page-main-block">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">Edit Profile</h5>
				</div>
			</div>
			<!-- breadcrumb -->
			<div id="breadcrumb" class="breadcrumb-main-block">
				<div class="breadcrumb-block">
					<ol class="breadcrumb">
						<li><a href="<?php echo e(url('/')); ?>" title="Home">Home</a></li>
						<li class="active">Edit Profile</li>
					</ol>
				</div>
			</div>
			<!-- breadcrumb end -->
			<div class="coupon-page-block categories-page edit-profile-page">
				<div class="coupon-dtl-outer">
					<div class="row">
						<div class="col-lg-9 col-md-8">
							<div class="submit-deal-main-block">
								<?php echo Form::model($auth, ['method' => 'PATCH','action' => ['UserDashboardController@profile_update', $auth->id], 'files' => true, 'class' => 'submit-deal-form contact-form']); ?>

									 <?php echo e(csrf_field()); ?>

									<div class="row">
										<div class="col-md-3 ac-profile-img">
											<img src="<?php echo e(asset('images/user/'.$auth->image)); ?>" alt="User">
										</div>
										<div class="col-md-9 form-group<?php echo e($errors->has('image') ? ' has-error' : ''); ?> input-file-block">
					            <?php echo Form::label('image', 'User Image'); ?> - <p class="inline info">Help block text</p>
					            <?php echo Form::file('image', ['class' => 'input-file', 'id'=>'image']); ?>

					            <p class="info">Choose custom image</p>
					            <small class="text-danger"><?php echo e($errors->first('image')); ?></small>
					          </div> 
					        </div>
									<div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
										<?php echo Form::label('name', 'Enter Your Full Name*'); ?>

										<?php echo Form::text('name', null, ['class' => 'form-control']); ?>

										<small class="text-danger"><?php echo e($errors->first('name')); ?></small>
									</div> 
									<div class="form-group<?php echo e($errors->has('dob') ? ' has-error' : ''); ?>">
										<?php echo Form::label('dob', 'Date of Birth'); ?>

										<?php echo Form::date('dob', null, ['class' => 'form-control']); ?>

										<small class="text-danger"><?php echo e($errors->first('dob')); ?></small>
									</div> 
									<div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
										<?php echo Form::label('email', 'Email Address*'); ?>

										<?php echo Form::email('email', null, ['class' => 'form-control', 'disabled']); ?>

										<small class="text-danger"><?php echo e($errors->first('email')); ?></small>
									</div> 
									<div class="form-group<?php echo e($errors->has('mobile') ? ' has-error' : ''); ?>">
										<?php echo Form::label('mobile', 'Enter Your Mobile Number*'); ?>

										<?php echo Form::text('mobile', null, ['class' => 'form-control', 'required']); ?>

										<small class="text-danger"><?php echo e($errors->first('mobile')); ?></small>
									</div> 
									<div class="form-group<?php echo e($errors->has('gender') ? ' has-error' : ''); ?>">
										<?php echo Form::label('gender', 'Choose Your Gender'); ?>

										<?php echo Form::select('gender', ['m' => 'Male', 'f' => 'Female'], null, ['class' => 'form-control select2']); ?>

										<small class="text-danger"><?php echo e($errors->first('gender')); ?></small>
									</div> 
									<div class="form-group<?php echo e($errors->has('address') ? ' has-error' : ''); ?>">
										<?php echo Form::label('address', 'Enter Your Address'); ?>

										<?php echo Form::textarea('address', null, ['class' => 'form-control']); ?>

										<small class="text-danger"><?php echo e($errors->first('address')); ?></small>
									</div> 
									<div class="form-group<?php echo e($errors->has('website') ? ' has-error' : ''); ?>">
										<?php echo Form::label('website', 'Enter Your Website'); ?>

										<?php echo Form::text('website', null, ['class' => 'form-control']); ?>

										<small class="text-danger"><?php echo e($errors->first('website')); ?></small>
									</div>
									<div class="form-group<?php echo e($errors->has('brief') ? ' has-error' : ''); ?>">
										<?php echo Form::label('brief', 'Biography'); ?>

										<?php echo Form::textarea('brief', null, ['class' => 'form-control']); ?>

										<small class="text-danger"><?php echo e($errors->first('brief')); ?></small>
									</div> 
									<div class="form-group">
										<div class="submit-deal-btn">
											<button type="submit" class="btn btn-primary">Submit</button>
										</div>
									</div>
								<?php echo Form::close(); ?> 
								<div class="form-group">
								  <a data-toggle="collapse" href="#changePassword" role="button" aria-expanded="false" aria-controls="changePassword">
							    	Want to change your password?
						  	  </a>
								</div> 
								<div class="collapse" id="changePassword">
									<?php echo Form::model($auth, ['method' => 'PATCH','action' => ['UserDashboardController@change_password', $auth->id], 'class' => 'submit-deal-form contact-form']); ?>

								 	<?php echo e(csrf_field()); ?>

									  <div class="form-group">
											<label for="old_password">Enter Old Password</label>
											<input type="password" id="old_password" name="old_password" class="form-control" placeholder="Enter Old Password" required="">
										</div>
										<div class="form-group">
											<label for="new_password">Enter New Password</label>
											<input type="password" id="new_password" class="form-control" name="new_password" placeholder="Enter New Password" required="">
										</div>
										<div class="form-group">
											<label for="new_password_confirmation">Confirm New Password</label>
											<input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="Confirm New Password" required="">
										</div>
										<div class="form-group">
											<div class="submit-deal-btn">
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>
										</div>
									<?php echo Form::close(); ?> 
								</div> 	
							</div>
						</div>
						<div class="col-lg-3 col-md-4">
							<div class="coupon-sidebar">
	      				<?php echo $__env->make('coupon.includes.side-bar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<!-- end forum -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('coupon.layouts.theme', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>