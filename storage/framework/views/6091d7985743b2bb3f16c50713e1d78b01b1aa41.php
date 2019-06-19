
<?php
	$settings=DB::table('settings')->first();
?>
<?php if(isset($p_store) && count($p_store)>0): ?>
	<div class="page-sidebar-widget popular-store-widget">
		<h6 class="widget-heading">Featured Stores</h6>
		<div id="sidebar-store-slider" class="sidebar-store-slider owl-carousel text-center">
			<?php $__currentLoopData = $p_store; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="brand-img-two">
					<a href="<?php echo e(url('store-dtl/'.$item->slug)); ?>" title="<?php echo e($item->title); ?>"><img src="<?php echo e(asset('images/store/'.$item->image)); ?>" class="img-fluid" alt="Store"></a>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
<?php endif; ?>
<?php if(isset($r_post) && count($r_post)>0): ?>
	<div class="page-sidebar-widget recent-posts-widget">
		<h6 class="widget-heading">Recent Deals</h6>
		<ul>                                        
			<?php $__currentLoopData = $r_post; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li><a href="<?php echo e(url('post/'.$post->uni_id.'/'.$post->slug)); ?>" title="Post"><?php echo e($post->title); ?></a></li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
	</div>
<?php endif; ?>
<?php if(isset($blogs_side) && count($blogs_side)>0): ?>
	<div class="page-sidebar-widget recent-posts-widget">
		<h6 class="widget-heading">Recent Blogs</h6>
		<ul>                                        
			<?php $__currentLoopData = $blogs_side; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li><a href="<?php echo e(url('blog-dtl/'.$blog->slug)); ?>" title="Post"><?php echo e($blog->title); ?></a></li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
	</div>
<?php endif; ?>
<div class="page-sidebar-widget sidebar-info-widget">
	<h6 class="widget-heading"><?php echo e($settings->w_name); ?></h6>
	<p><?php echo e($settings->sidebar_abt); ?></p>
</div>
