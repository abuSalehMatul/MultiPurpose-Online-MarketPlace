<?php $__env->startSection('main-content'); ?>
<?php
	$auth=Auth::user();
?>
<!-- submit -->
	<section id="forum" class="coupon-page-main-block">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">Submit Deals</h5>
				</div>
			</div>
			<!-- breadcrumb -->
			<div id="breadcrumb" class="breadcrumb-main-block">
				<div class="breadcrumb-block">
					<ol class="breadcrumb">
						<li><a href="<?php echo e(url('/')); ?>" title="Home">Home</a></li>
						<li class="active">Submit Deals</li>
					</ol>
				</div>
			</div>
			<!-- breadcrumb end -->
			<div class="coupon-page-block categories-page submit-deal-page">
				<div class="coupon-dtl-outer">
					<div class="row">
						<div class="col-lg-9 col-md-8">
							<div class="submit-deal-main-block">
								<div class="form-group post-type">
									<label>Select Type</label>
									<ul class="nav" id="post-type" role="tablist">
									  <li class="nav-item">
									    <a class="nav-link active" id="coupon-tab" data-toggle="pill" href="#coupon" role="tab" aria-controls="coupon" aria-selected="false"><div class="post-type-icon"><i class="fas fa-tag"></i></div>Coupon</a>
									  </li>
									  <li class="nav-item">
									    <a class="nav-link" id="deal-tab" data-toggle="pill" href="#deal" role="tab" aria-controls="deal" aria-selected="false"><div class="post-type-icon"><i class="fas fa-handshake"></i></div>Deal</a>
									  </li>
									  <li class="nav-item">
									    <a class="nav-link" id="discussion-tab" data-toggle="pill" href="#discussion" role="tab" aria-controls="discussion" aria-selected="false"><div class="post-type-icon"><i class="fas fa-comments"></i></div>Discussion</a>
									  </li>
									</ul>
								</div>								
								<div class="form-group">
									<div class="tab-content" id="post-type-content">
									  <div class="tab-pane fade active show" id="coupon" role="tabpanel" aria-labelledby="coupon-tab">									  	
											<?php echo Form::open(['method' => 'POST', 'action' => 'UserDashboardController@coupon_post', 'files' => true, 'class' => 'submit-deal-form']); ?>											
												<input type="hidden" name="type" value="c"> 										
												<input type="hidden" name="user_id" value="<?php echo e($auth->id); ?>"> 
							          <div class="form-group<?php echo e($errors->has('forum_category_id') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('forum_category_id', 'Choose Coupon Category*'); ?>

						              <?php echo Form::select('forum_category_id', $cat_coupon, null, ['class' => 'form-control select2', 'required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('forum_category_id')); ?></small>
							          </div> 
												<div class="form-group<?php echo e($errors->has('store_id') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('store_id', 'Choose Store*'); ?>

						              <?php echo Form::select('store_id', $all_store, null, ['class' => 'form-control select2', 'required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('store_id')); ?></small>
						          	</div> 
						          	<div class="form-group<?php echo e($errors->has('category_id') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('category_id', 'Choose Category*'); ?>

						              <?php echo Form::select('category_id', $all_category, null, ['class' => 'form-control select2', 'required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('category_id')); ?></small>
						          	</div> 
						          	<div class="form-group<?php echo e($errors->has('title') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('title', 'Enter Coupon Name/Title*'); ?>

						              <?php echo Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Detailed Coupon Title', 'required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('title')); ?></small>
							          </div>  
							          <div id="ccode" class="form-group<?php echo e($errors->has('code') ? ' has-error' : ''); ?>">
							              <?php echo Form::label('code', 'Enter Coupon Code*'); ?>

							              <?php echo Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'Like SAVE10']); ?>

							              <small class="text-danger"><?php echo e($errors->first('code')); ?></small>
							          </div>     
							          <div class="form-group<?php echo e($errors->has('price') ? ' has-error' : ''); ?>">
							              <?php echo Form::label('price', 'Coupon Price'); ?>

							              <?php echo Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Enter Actual Price of Coupon']); ?>

							              <small class="text-danger"><?php echo e($errors->first('price')); ?></small>
							          </div> 
							          <div class="form-group<?php echo e($errors->has('discount') ? ' has-error' : ''); ?>">
							              <?php echo Form::label('discount', 'Coupon Discount'); ?>

							              <?php echo Form::text('discount', null, ['class' => 'form-control', 'placeholder' => 'Enter Coupon Discount']); ?>

							              <small class="text-danger"><?php echo e($errors->first('discount')); ?></small>
							          </div>  
							          <div class="form-group<?php echo e($errors->has('link') ? ' has-error' : ''); ?>">
							              <?php echo Form::label('link', 'Deal Product URL/Link'); ?>

							              <?php echo Form::text('link', null, ['class' => 'form-control', 'placeholder' => 'https://www.foo.com']); ?>

							              <small class="text-danger"><?php echo e($errors->first('link')); ?></small>
							          </div>   
							          <div class="form-group<?php echo e($errors->has('expiry') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('expiry', 'Coupon Expiry Date'); ?>

						              <?php echo Form::text('expiry', null, ['class' => 'form-control date-pick', 'placeholder' => 'DD/MM/YYYY']); ?>

						              <small class="text-danger"><?php echo e($errors->first('expiry')); ?></small>
						         		</div>
						          	<div class="form-group<?php echo e($errors->has('detail') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('detail', 'Coupon Description*'); ?>

						              <?php echo Form::textarea('detail', null, ['class' => 'form-control', 'placeholder' => 'Enter Detailed Description','required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('detail')); ?></small>
						          	</div>
							          <div class="form-group<?php echo e($errors->has('image') ? ' has-error' : ''); ?> input-file-block">
							            <?php echo Form::label('image', 'Choose Coupon Image'); ?> 
							            <?php echo Form::file('image', ['class' => 'input-file', 'id'=>'image']); ?>

							            
							            <p class="info">Choose custom image</p>
							            <small class="text-danger"><?php echo e($errors->first('image')); ?></small>
							          </div> 
												<div class="form-group">
													<div class="submit-deal-btn">
														<button type="submit" class="btn btn-primary">Submit</button>
													</div>
												</div>
											<?php echo Form::close(); ?>

									  </div>
										<div class="tab-pane fade active" id="deal" role="tabpanel" aria-labelledby="deal-tab">
											<?php echo Form::open(['method' => 'POST', 'action' => 'UserDashboardController@coupon_post', 'files' => true, 'class' => 'submit-deal-form']); ?>												
												<input type="hidden" name="type" value="d"> 			
												<input type="hidden" name="user_id" value="<?php echo e($auth->id); ?>"> 
												<div class="form-group<?php echo e($errors->has('forum_category_id') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('forum_category_id', 'Choose Deal Category*'); ?>

						              <?php echo Form::select('forum_category_id', $cat_deal, null, ['class' => 'form-control select2', 'required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('forum_category_id')); ?></small>
							          </div> 
							          <div class="form-group<?php echo e($errors->has('store_id') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('store_id', 'Choose Store*'); ?>

						              <?php echo Form::select('store_id', $all_store, null, ['class' => 'form-control select2', 'required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('store_id')); ?></small>
						          	</div> 
						          	<div class="form-group<?php echo e($errors->has('category_id') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('category_id', 'Choose Category*'); ?>

						              <?php echo Form::select('category_id', $all_category, null, ['class' => 'form-control select2', 'required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('category_id')); ?></small>
						          	</div> 
						          	<div class="form-group<?php echo e($errors->has('title') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('title', 'Enter Deal Name/Title*'); ?>

						              <?php echo Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Detailed Deal Title', 'required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('title')); ?></small>
							          </div>        
							          <div class="form-group<?php echo e($errors->has('price') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('price', 'Deal Price'); ?>

						              <?php echo Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Enter Actual Price of Deal']); ?>

						              <small class="text-danger"><?php echo e($errors->first('price')); ?></small>
							          </div> 
							          <div class="form-group<?php echo e($errors->has('discount') ? ' has-error' : ''); ?>">
							              <?php echo Form::label('discount', 'Deal Discount'); ?>

							              <?php echo Form::text('discount', null, ['class' => 'form-control', 'placeholder' => 'Enter Deal Discount']); ?>

							              <small class="text-danger"><?php echo e($errors->first('discount')); ?></small>
							          </div>
							          <div class="form-group<?php echo e($errors->has('link') ? ' has-error' : ''); ?>">
							              <?php echo Form::label('link', 'Deal Product URL/Link'); ?>

							              <?php echo Form::text('link', null, ['class' => 'form-control', 'placeholder' => 'https://www.foo.com']); ?>

							              <small class="text-danger"><?php echo e($errors->first('link')); ?></small>
							          </div>
							          <div class="form-group<?php echo e($errors->has('expiry') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('expiry', 'Deal Expiry Date'); ?>

						              <?php echo Form::text('expiry', null, ['class' => 'form-control date-picker']); ?>

						              <small class="text-danger"><?php echo e($errors->first('expiry')); ?></small>
						         		</div>
						          	<div class="form-group<?php echo e($errors->has('detail') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('detail', 'Deal Description*'); ?>

						              <?php echo Form::textarea('detail', null, ['class' => 'form-control', 'placeholder' => 'Enter Detailed Description','required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('detail')); ?></small>
						          	</div>
							          <div class="form-group<?php echo e($errors->has('image') ? ' has-error' : ''); ?> input-file-block">
							            <?php echo Form::label('image', 'Choose Deal Image'); ?> - <p class="inline info">Help block text</p>
							            <?php echo Form::file('image', ['class' => 'input-file', 'id'=>'image']); ?>

							            
							            <p class="info">Choose custom image</p>
							            <small class="text-danger"><?php echo e($errors->first('image')); ?></small>
							          </div> 
												<div class="form-group">
													<div class="submit-deal-btn">
														<button type="submit" class="btn btn-primary">Submit</button>
													</div>
												</div>
											<?php echo Form::close(); ?>

										</div>
										<div class="tab-pane fade" id="discussion" role="tabpanel" aria-labelledby="discussion-tab">											
											<?php echo Form::open(['method' => 'POST', 'action' => 'UserDashboardController@discussion_post', 'files' => true, 'class' => 'submit-deal-form']); ?>    														
												<input type="hidden" name="type" value="g"> 			
												<input type="hidden" name="user_id" value="<?php echo e($auth->id); ?>"> 
							          <div class="form-group<?php echo e($errors->has('forum_category_id') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('forum_category_id', 'Choose Discussion Category*'); ?>

						              <?php echo Form::select('forum_category_id', $cat_discussion, null, ['class' => 'form-control', 'required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('forum_category_id')); ?></small>
							          </div> 
						          	<div class="form-group<?php echo e($errors->has('title') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('title', 'Discussion Title*'); ?>

						              <?php echo Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Discussion Title', 'required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('title')); ?></small>
							          </div> 
							          <div class="form-group<?php echo e($errors->has('detail') ? ' has-error' : ''); ?>">
						              <?php echo Form::label('detail', 'Discussion Description*'); ?>

						              <?php echo Form::textarea('detail', null, ['class' => 'form-control', 'placeholder' => 'Enter Detailed Description','required']); ?>

						              <small class="text-danger"><?php echo e($errors->first('detail')); ?></small>
							          </div>
							          <div class="form-group<?php echo e($errors->has('image') ? ' has-error' : ''); ?> input-file-block">
							            <?php echo Form::label('image', 'Discussion Image'); ?> - <p class="inline info">Help block text</p>
							            <?php echo Form::file('image', ['class' => 'input-file', 'id'=>'image']); ?>

							            
							            <small class="text-danger"><?php echo e($errors->first('image')); ?></small>
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