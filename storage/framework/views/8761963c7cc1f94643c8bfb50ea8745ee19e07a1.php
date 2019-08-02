<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo e(env('APP_NAME')); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="KCHEPAS" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon"  href="<?php echo e(asset('assets/images/favicon.ico')); ?>">
        <?php echo $__env->make('backend.layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    </head>

    <body>

        <!-- Navigation Bar-->
        <header id="topnav">
      <?php echo $__env->make('backend.layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php echo $__env->make('backend.layouts.nav-horizontal', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </header>
        <!-- End Navigation Bar-->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
            <div class="wrapper">
                <div class="container-fluid">
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('backend.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>    
    <?php echo $__env->make('backend.layouts.right-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
                </div> <!-- end wrapper -->
            </div>
            <!-- end wrapper -->
    <?php echo $__env->make('backend.layouts.footer-script', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>    
    </body>
</html>