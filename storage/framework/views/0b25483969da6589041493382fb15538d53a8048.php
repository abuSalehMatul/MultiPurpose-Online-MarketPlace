<?php $__env->startSection('main-content'); ?>
<?php
	$auth=Auth::user();
?>
	<!-- account -->
	<section id="account" class="coupon-page-main-block account-page-main">
		<div class="container">
			<div class="forum-page-header">
				<div class="forum-page-heading-block">
					<h5 class="forum-page-heading">My Account</h5>
				</div>
			</div>
			<!-- breadcrumb -->
			<div id="breadcrumb" class="breadcrumb-main-block">
				<div class="breadcrumb-block">
					<ol class="breadcrumb">
						<li><a href="<?php echo e(url('/')); ?>" title="Home">Home</a></li>
						<li class="active">My Account</li>
					</ol>
				</div>
			</div>
			<!-- breadcrumb end -->
			<div class="account-page">
				<div class="coupon-dtl-outer">
					<div class="row">
						<div class="col-md-9">
							<div class="account-main-block account-box">
								<div class="row">
									<div class="col-lg-3">
										<div class="ac-profile-block">
											<div class="ac-profile-img">
												<img src="<?php echo e(asset('/coupon/images/user/'.$auth->image)); ?>" alt="User">
											</div>
											<h6 class="ac-username"><?php echo e($auth->name); ?></h6>
											<div class="ac-post"><?php echo e($auth->is_admin == '1' ? 'Administrator' : 'User'); ?></div>
										</div>
									</div>
									<div class="col-lg-9">
										<div class="ac-profile-dtl">
											<h6 class="ac-holder-name"><?php echo e($auth->name); ?></h6>
											<div class="join-date">Joined Coupon on <?php echo e($auth->created_at->format('jS F, Y')); ?></div>
											<div class="ac-holder-info">
												<p><?php echo e($auth->brief); ?></p>
											</div>
										</div>
										<div class="row">
											<?php if(count($followers)>0): ?>
												<div class="col-md-4">
													<div class="ac-btn">
														<a id="ac-followers-btn" href="#ac-followers" class="btn btn-primary" title="Followers" data-scroll>Followers</a>
													</div>
												</div>
											<?php endif; ?>											
											<?php if(count($followings) >0): ?>
												<div class="col-md-4">
													<div class="ac-btn">
														<a id="ac-followings-btn" href="#ac-followings" class="btn btn-primary" title="Followings" data-scroll>Followings</a>
													</div>
												</div>
											<?php endif; ?>
											<div class="col-md-4">
												<div class="ac-btn">
													<a href="<?php echo e(url('user/profile-edit')); ?>" class="btn btn-primary" title="Edit Profile">Edit Profile</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="ac-facts account-box text-center">
								<div class="row">
									<div class="col-lg-3 col-md-6">
										<div class="facts-block">
											<h1 class="fact-heading"><?php echo e($deal); ?></h1>
											<h6 class="fact-name">Deals Posted</h6>
										</div>
									</div>
									<div class="col-lg-3 col-md-6">
										<div class="facts-block">
											<h1 class="fact-heading"><?php echo e($coupon); ?></h1>
											<h6 class="fact-name">Coupons Posted</h6>
										</div>
									</div>
									<div class="col-lg-3 col-md-6">
										<div class="facts-block">
											<h1 class="fact-heading"><?php echo e(count($followers)); ?></h1>
											<h6 class="fact-name">Followers</h6>
										</div>
									</div>
									<div class="col-lg-3 col-md-6">
										<div class="facts-block">
											<h1 class="fact-heading"><?php echo e(count($followings)); ?></h1>
											<h6 class="fact-name">Followings</h6>
										</div>
									</div>
								</div>
							</div>
							<?php if(isset($post) && count($post) > 0): ?>
								<div class="ac-post-block account-box">
									<h6 class="ac-page-heading">Your Recent Posts</h6>
									<div class="row">									
										<?php $__currentLoopData = $post; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="col-lg-4 col-md-6">
												<div class="deal-block recent-deals">
													<div class="deal-img">
														<a href="<?php echo e(url('post/'.$item->uni_id.'/'.$item->slug)); ?>" title="<?php echo e($item->title); ?>"><img src="<?php echo e($item->image != null ? asset('/coupon/images/coupon/'.$item->image) : asset('/coupon/images/store/'.$item->store->image)); ?>" class="img-fluid" alt="Deal"></a>
													</div>
													<div class="deal-dtl">
														<?php if($item->is_featured == 1): ?>
															<div class="deal-badge red-badge">Featured</div>
														<?php elseif($item->is_exclusive == 1): ?>
															<div class="deal-badge green-badge">Exclusive</div>
														<?php endif; ?>
														<div class="deal-merchant"><?php echo e($item->store->title); ?>

														</div>
														<h6 class="deal-title"><a href="<?php echo e(url('post/'.$item->uni_id.'/'.$item->slug)); ?>" title="<?php echo e($item->title); ?>"><?php echo e(str_limit($item->title, 60)); ?></a></h6>
														<div class="deal-price-block">
															<div class="row">
																<div class="col-6">
																	<div class="deal-price">
																		<?php if($item->price): ?>
																			<sup><i class="<?php echo e($settings->currency); ?>" aria-hidden="true"></i></sup> <?php echo e($item->price); ?>

																			<?php else: ?>
																				<?php echo e($item->discount ? $item->discount."% Off" : ''); ?>

																			<?php endif; ?>
																	</div>
																	
																</div>
																<div class="col-6 text-right">
																		<div class="rating">
									                    <div class="set-rating" data-rateyo-rating="<?php echo e($item->rating>0 ? $item->rating : '0'); ?>"></div>
									                  </div>
																</div>
															</div>
														</div>
													</div>
													<div class="deal-footer">
														<div class="row">
															<div class="col-5">
																<div class="comments-icon">
																	<i class="far fa-comments"></i><a href="<?php echo e(url('post/'.$item->uni_id.'/'.$item->slug)); ?>" title="Comments"><?php echo e($item->comments()->count()); ?></a>
																</div>
																<div class="comments-icon">
																	<i class="fa fa-eye"></i><?php echo e($item->views()->count()); ?>

																</div>
															</div>
															<div class="col-7">
																<div class="deal-user">
																	<div class="row">
																		<div class="col-4">
																			<div class="user-img">
																				<a href="<?php echo e(url('profile/'.$item->user_id)); ?>" title="User"><img src="<?php echo e(asset('/coupon/images/user/'.$item->user->image)); ?>" class="img-fluid" alt="User"></a>
																			</div>
																		</div>
																		<div class="col-sm-8">
																			<div class="user-name">
																				<a href="<?php echo e(url('profile/'.$item->user_id)); ?>" title="User"><?php echo e(strtok($item->user->name,' ')); ?></a>
																			</div>
																			<div class="deal-time"><?php echo e($item->created_at->diffForHumans()); ?></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
							<?php endif; ?>
							<?php if(isset($followers) && count($followers)>0): ?>
								<div id="ac-followers" class="ac-followers-block account-box">
									<h6 class="ac-page-heading">Followers</h6>
									<div class="row">										
										<?php $__currentLoopData = $followers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="col-xs-1">
												<div class="ac-profile-img">
													<a href="<?php echo e(url('profile/'.$item->id)); ?>" title="<?php echo e($item->name); ?>"><img src="<?php echo e(asset('/coupon/images/user/'.$item->image)); ?>" class="img-fluid" alt="User"></a>
												</div>
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
							<?php endif; ?>
							<?php if(isset($followings) && count($followings)>0): ?>
								<div id="ac-followings" class="ac-followers-block account-box">
									<h6 class="ac-page-heading">Followings</h6>
									<div class="row">
										<?php $__currentLoopData = $followings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="col-xs-1">
												<div class="ac-profile-img">
													<a href="<?php echo e(url('profile/'.$item->id)); ?>" title="<?php echo e($item->name); ?>"><img src="<?php echo e(asset('/coupon/images/user/'.$item->image)); ?>" class="img-fluid" alt="User"></a>
												</div>
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<div class="col-md-3">
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