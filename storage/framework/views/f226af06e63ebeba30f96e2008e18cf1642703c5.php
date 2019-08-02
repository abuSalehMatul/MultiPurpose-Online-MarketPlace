        <!-- Vendor js -->
        <script src="<?php echo e(URL::asset('backend/assets/js/vendor.min.js')); ?>"></script>

        <?php echo $__env->yieldContent('script'); ?>

        <!-- App js -->
        <script src="<?php echo e(URL::asset('backend/assets/js/app.min.js')); ?>"></script>
        
        <?php echo $__env->yieldContent('script-bottom'); ?>