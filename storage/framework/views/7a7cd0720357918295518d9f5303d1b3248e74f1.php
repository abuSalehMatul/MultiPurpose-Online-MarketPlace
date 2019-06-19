<?php
	$settings=DB::table('settings')->first();
?>
<?php $__env->startSection('main-content'); ?>
<!-- slider start -->
	<section id="slider" class="slider <?php echo e($slider->is_parallax ? 'parallax' : ''); ?>" style="background-image: url('<?php echo e(asset('images/'.$slider->image)); ?>">
		<?php if($slider->is_overlay): ?>
			<div class="overlay-bg"></div>
		<?php endif; ?>
		<div class="container">
			<div class="slider-block text-center">
				<div class="slider-dtl">
					<h1 class="slider-heading"><?php echo e($slider->heading); ?></h1>
					<p><?php echo e($slider->subheading); ?></p>
				</div>			
				<div class="search-block">
					<?php echo Form::open(['method' => 'GET', 'action' => 'SearchController@homeSearch', 'class' => 'search-form']); ?>

						<?php echo Form::text('search', null, ['class' => 'search-input', 'placeholder' => 'Search']); ?>

					  <button type="submit" class="search-button">
					    <svg class="submit-button">
					      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#search"></use>
					    </svg>
					  </button>
				  <?php echo Form::close(); ?>

					<svg xmlns="http://www.w3.org/2000/svg" width="0" height="0" display="none">
					  <symbol id="search" viewBox="0 0 32 32">
					    <path d="M 19.5 3 C 14.26514 3 10 7.2651394 10 12.5 C 10 14.749977 10.810825 16.807458 12.125 18.4375 L 3.28125 27.28125 L 4.71875 28.71875 L 13.5625 19.875 C 15.192542 21.189175 17.250023 22 19.5 22 C 24.73486 22 29 17.73486 29 12.5 C 29 7.2651394 24.73486 3 19.5 3 z M 19.5 5 C 23.65398 5 27 8.3460198 27 12.5 C 27 16.65398 23.65398 20 19.5 20 C 15.34602 20 12 16.65398 12 12.5 C 12 8.3460198 15.34602 5 19.5 5 z" />
					  </symbol>
					</svg>
				</div>
				<div class="slider-btn">
					<div class="row">
						<div class="col-md-6 text-right">
							<a href="<?php echo e($settings->btn_link); ?>" class="btn btn-primary" title="<?php echo e($settings->btn_title); ?>"><?php echo e($settings->btn_title); ?></a>
						</div>
						<div class="col-md-6 text-left">
							<a href="<?php echo e($settings->btn_link2); ?>" class="btn btn-primary" title="<?php echo e($settings->btn_title2); ?>"><?php echo e($settings->btn_title2); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<!-- end slider -->
<!-- home categories -->
	<section id="home-cat" class="home-cat-main-block">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 d-none d-lg-block">
					<div class="cat-nav home-filter">
						<ul>
							<li id="all" class="cat-link active"><a href="#" title="All">Recent</a></li>
							<li id="featured" class="cat-link"><a href="#" title="New Deals">Featured</a></li>
							<li id="trending" class="cat-link"><a href="#" title="Trending">Trending</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="home-filter cat-nav-two">
						<ul>
							<li>
								<div class="sort-dropdown">
									<?php if(isset($store_list) && count($store_list) > 0): ?>
									  <select class="form-control" name="store" id="store-list">
											<option value="all">By Merchant</option>
											<?php $__currentLoopData = $store_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($item->id); ?>"><?php echo e(strtok($item->title,' ')); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												
										</select>
									<?php endif; ?>
								</div>
							</li>
							<li>
								<div class="sort-dropdown">
									<?php if(isset($category_list) && count($category_list) > 0): ?>
								  	<select class="form-control" name="store" id="cat-list">
											<option value="all">By Category</option>
											<?php $__currentLoopData = $category_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($item->id); ?>"><?php echo e(strtok($item->title,' ')); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											
										</select>
									<?php endif; ?>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-1">
					<div class="cat-nav-two">
						<ul>
							<li class="layout-icon"><a href="<?php echo e(url('/')); ?>" title="Grid"><i class="fas fa-th"></i></a></li>
							<li class="layout-icon"><a href="<?php echo e(url('home-list')); ?>" title="List"><i class="fas fa-list"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
<!-- end home categories -->
<!-- deal -->
	<section id="deal" class="deal-main-block">
		<div class="container">
			<?php if(isset($settings) && $settings->is_feat_slider): ?>
				<div class="featured-deal-main">
					<?php if(isset($feat_deal) && count($feat_deal) > 0): ?>
						<div class="section">
							<h6 class="section-heading">Featured Deals & Coupons</h6>
						</div>
						<div id="featured-deal-slider" class="featured-deal-slider owl-carousel">	 <?php $__currentLoopData = $feat_deal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="deal-block menu-deal-block">
									<div class="deal-img">
										<a href="<?php echo e(url('post/'.$item->uni_id.'/'.$item->slug)); ?>" title="Deal"><img src="<?php echo e($item->image != null ? asset('images/coupon/'.$item->image) : asset('images/store/'.$item->store->image)); ?>" class="img-fluid" alt="Deal"></a>
									</div>
									<div class="deal-dtl text-center">
										<h6 class="deal-title"><a href="<?php echo e(url('post/'.$item->uni_id.'/'.$item->slug)); ?>" title="Deal"><?php echo e(str_limit($item->title, 30)); ?></a></h6>
									</div>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>			
			<?php if(isset($settings) && $settings->is_recent_deals): ?>
				<h6 class="section-heading">Deals & Coupons</h6>
				<div id="home-filter-section">
					<?php if(isset($results) && count($results) > 0): ?>
						<div class="row results">										
							<?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="col-lg-3 col-md-4 col-sm-6">
									<div class="deal-block recent-deals">
										<div class="deal-img">
											<a href="<?php echo e(url('post/'.$item->uni_id.'/'.$item->slug)); ?>" title="<?php echo e($item->title); ?>"><img src="<?php echo e($item->image != null ? asset('images/coupon/'.$item->image) : asset('images/store/'.$item->store->image)); ?>" class="img-fluid" alt="Deal"></a>
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
																	<a href="<?php echo e(url('profile/'.$item->user_id)); ?>" title="User"><img src="<?php echo e(asset('images/user/'.$item->user->image)); ?>" class="img-fluid" alt="User"></a>
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
					<?php else: ?>
						<p>No Results</p>
					<?php endif; ?>
				</div>
				<div id="results"><!-- results appear here --></div>
				<?php if(count($results)>35): ?>
					<div class="btn btn-primary load-more-btn">Load More</div>
				<?php endif; ?>
    		<div class="ajax-loading text-center"><i class="fa fa-spinner fa-spin" style="font-size:40px"></i></div>
			<?php endif; ?>
		</div>
	</section>
<!-- end deal -->
<!-- categories -->
<?php if(isset($settings) && $settings->is_category_block): ?>
	<section id="categories" class="categories-main-block">
		<div class="container">			
			<?php if(isset($category_list) && count($category_list) > 0): ?>
				<div class="section">
					<h4 class="section-heading">Categories</h4>
				</div>
				<div class="cat-block text-center">
					<div class="row">
						<?php $__currentLoopData = $category_list->take(12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-lg-2 col-md-4">
								<div class="category-block">
									<a href="<?php echo e(url('category-dtl/'.$item->slug)); ?>" title="Categories">
										<div class="cat">
											<div class="<?php echo e($item->icon ? 'cat-icon' : ''); ?>">
												<?php if($item->icon): ?>
													<i class="fa <?php echo e($item->icon); ?>"></i>
												<?php else: ?>
													<img src="<?php echo e(asset('images/category/'.$item->image)); ?>" class="img-fluid" alt="category">
												<?php endif; ?>
											</div>
											<h5 class="cat-title"><?php echo e(strtok($item->title,' ')); ?></h5>
										</div>
									</a>
								</div>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
<!-- end categories -->
<!-- blogs -->
<?php if(isset($blogs)): ?>
	<section id="home-blog" class="home-blog-main-block">
		<div class="container">
			<div class="section">
				<h4 class="section-heading">Recent Blogs</h4>
			</div>
			<div class="blog-page-outer blog-page-two">
				<div class="blog-page-main-block">
					<div class="row">
						<?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-lg-4 col-md-6">
								<div class="blog-post-main">
									<div class="blog-img">
										<a href="<?php echo e(url('blog-dtl/'.$blog->uni_id.'/'.$blog->slug)); ?>" title="Blog Post"><img src="<?php echo e(asset('images/blog/'.$blog->image)); ?>" class="img-fluid" alt="Blog Post"></a>
									</div>
									<div class="blog-post-dtl">
										<h6 class="blog-post-heading"><a href="blog-post.html" title="Blog Post"><?php echo e($blog->title); ?></a></h6>
										<div class="blog-post-tags">
											<ul>
												<li><i class="far fa-clock"></i><?php echo e(date('d F Y', strtotime($blog->created_at))); ?></li>
												<li><i class="far fa-user"></i><a href="<?php echo e(url('profile/'.$blog->users->id)); ?>" title="<?php echo e($blog->users->name); ?>"><?php echo e($blog->users->name); ?></a></li>
												<li><i class="far fa-comments"></i><?php echo e($blog->comments()->count()); ?></li>
											</ul>
										</div>
										<div class="blog-post-text">
											<p><?php echo \Illuminate\Support\Str::words($blog->desc,170,'...'); ?></p>
										</div>
										<div class="blog-post-link">
											<a href="<?php echo e(url('blog-dtl/'.$blog->uni_id.'/'.$blog->slug)); ?>" title="Read More">Read More</a>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
<!-- end blogs -->
<!-- featured stores -->
<?php if(isset($settings) && $settings->is_store_slider): ?>
	<div id="featured-stores" class="featured-stores-main-block">
		<div class="container">
			<?php if(isset($store) && count($store) > 0): ?>
				<div id="featured-store-slider" class="featured-stores-slider owl-carousel">
					<?php $__currentLoopData = $store; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="store-img">
							<a href="<?php echo e(url('store-dtl/'.$item->slug)); ?>" title="Store"><img src="<?php echo e(asset('images/store/'.$item->image)); ?>" class="img-fluid" alt="Store"></a>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
<!-- end featured stores -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom-scripts'); ?>
<script>
$(document).ready(function(){$(".cat-nav li").click(function(e){e.preventDefault();$(this).addClass("active"),$(this).parent().children("li").not(this).removeClass("active")});var e="all",t="all",a="all",l=1;function n(l){$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},type:"GET",url:"<?php echo e(url('homefilter')); ?>?page="+l,data:{filter:t,s_filter:e,c_filter:a,main:"0"},datatype:"html",beforeSend:function(){$(".load-more-btn").hide(),$(".ajax-loading").show()},success:function(e){console.log(e)},error:function(e,t,a){console.log(e)}}).done(function(e){if(!e)return console.log("no"),$(".ajax-loading").hide(),1==l&&$(".results").html("No Results Found!"),0;$(".ajax-loading").hide(),1==l?$(".results").html(e):$(".results").append(e),$(e).find(".deal-block").length>35&&$(".load-more-btn").show()}).fail(function(e,t,a){alert("We are facing some issues currenlty. Please try again later.")})}$(".home-filter li").on("click change keyup",function(){t=$(".cat-nav li.active").attr("id"),e=$("#store-list").val(),a=$("#cat-list").val(),console.log(a),console.log(t),n(l=1)}),$(".load-more-btn").on("click",function(){n(++l)})});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('coupon.layouts.theme', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>