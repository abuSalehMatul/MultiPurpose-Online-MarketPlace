<?php $__env->startPush('stylesheets'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('header'); ?>
	<?php echo $__env->make('pro.includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
<?php echo $__env->yieldPushContent('stylesheets'); ?>
<main id="wt-main" class="wt-main wt-innerbgcolor wt-haslayout <?php echo e(!empty($body_class) ? $body_class : ''); ?>">
	<?php echo $__env->yieldContent('content'); ?>
</main>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
	<?php echo $__env->make('pro.front-end.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('pro.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>