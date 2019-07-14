<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo e($page_title); ?> | <?php echo e($basic->sitename); ?> </title>
    <!-- favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('learn/assets/images/logo/favicon.png')); ?>"/>
    <!-- bootstrap -->
    <link rel="stylesheet" href="<?php echo e(asset('learn/assets/front/css/bootstrap.min.css')); ?>">

    <!-- stylesheet -->
    <link rel="stylesheet" href="<?php echo e(asset('learn/assets/front/css/owl.carousel.css')); ?>">
    <!-- fontawesome -->

    <link rel="stylesheet" href="<?php echo e(asset('learn/assets/front/css/fontawesome-all.min.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- slicknav -->
    <link rel="stylesheet" href="<?php echo e(asset('learn/assets/front/css/slicknav.min.css')); ?>">
    <!-- jquery ui css -->
    <link rel="stylesheet" href="<?php echo e(asset('learn/assets/front/css/jquery-ui.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('learn/assets/front/css/sweetalert.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('learn/assets/front/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('learn/assets/front/css/custom-menu.css')); ?>">
    <?php echo $__env->yieldContent('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('learn/assets/front/css/style.php')); ?>?color=<?php echo e($basic->color); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('learn/assets/front/css/style2.php')); ?>?color2=<?php echo e($basic->color2); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('learn/assets/front/css/hover.php')); ?>?hover=<?php echo e($basic->hover); ?>">
    <!-- responsive -->
    <link rel="stylesheet" href="<?php echo e(asset('learn/assets/front/css/responsive.css')); ?>">

</head>
<body>


<!-- support bar area start -->
<div class="support-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <a href="<?php echo e(route('learn.homepage')); ?>" class="logo">
                    <img src="<?php echo e(asset('learn/assets/images/logo/logo.png')); ?>" alt="logo">
                </a>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
                <div class="support-right">
                    <div class="single-support-box">
                        <h3><?php echo $basic->short_heading; ?></h3>
                        <p><?php echo $basic->short_notes; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="support-btn">
                    <a href="<?php echo e(route('live.class')); ?>" class="boxed-btn pointer">Live Class</a>
                </div>
            </div>
        </div>
    </div>
</div> <!--end support bar area -->


<?php echo $__env->yieldContent('content'); ?>





<!-- footer area start -->
<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 width-50">
                <div class="widget-area">
                    <div class="widget-header">
                        <a href="<?php echo e(url('/')); ?>" class="logo">
                            <img src="<?php echo e(asset('assets/images/logo/logo.png')); ?>" alt="logo image">
                        </a>
                    </div>
                    <div class="widget-body">
                        <p><?php echo $basic->breadcrumb_text; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="widget-area">
                            <div class="widget-header">
                                <h4>Quick Links</h4>
                            </div>
                            <div class="widget-body">
                                <ul>
                                    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                                    <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e(route('menu',$menu->slug)); ?>"><?php echo e($menu->name); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(route('about')); ?>">About Us</a></li>
                                    <li><a href="<?php echo e(route('faqs')); ?>">Faqs</a></li>
                                    <li><a href="<?php echo e(route('contact')); ?>">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="widget-area">
                            <div class="widget-header">
                                <h4>Learn Category</h4>
                            </div>
                            <div class="widget-body">
                                <ul>
                                    <?php $__currentLoopData = $postCategoryNull; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $slug = str_slug($data->name);
                                        ?>
                                        <li>
                                            <a href="<?php echo e(route('article.categories',[$data->id, $slug])); ?>"><?php echo e($data->name or '-'); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="widget-area">
                            <div class="widget-header empty-title"></div>
                            <div class="widget-body">
                                <ul>

                                    <?php $__currentLoopData = $postCategoryNotNull; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $slug = str_slug($data->name);
                                        ?>
                                        <li><a href="<?php echo e(route('article.categories',[$data->id, $slug])); ?>"><?php echo e($data->short_name or $data->name); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="widget-area">
                    <div class="widget-header">
                        <h4>Connect Us </h4>
                    </div>
                    <div class="widget-body">
                        <ul>
                            <?php $__currentLoopData = $social; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e($data->link); ?>"><?php echo $data->code; ?> <?php echo e($data->name); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- jquery -->
<script src="<?php echo e(asset('learn/assets/front/js/jquery.js')); ?>"></script>
<!-- bootstrap -->
<script src="<?php echo e(asset('learn/assets/front/js/bootstrap.min.js')); ?>"></script>
<!-- slicknav -->
<script src="<?php echo e(asset('learn/assets/front/js/jquery.slicknav.min.js')); ?>"></script>
<!-- imagesloaded -->
<script src="<?php echo e(asset('learn/assets/front/js/imagesloaded.pkgd.min.js')); ?>"></script>
<!-- jqury ui  -->
<script src="<?php echo e(asset('learn/assets/front/js/jquery-ui.js')); ?>"></script>
<script src="<?php echo e(asset('learn/assets/front/js/jquery.nicescroll.js')); ?>"></script>
<script src="<?php echo e(asset('learn/assets/front/js/sweetalert.js')); ?>"></script>
<!-- isotope -->
<script src="<?php echo e(asset('learn/assets/front/js/isotope.pkgd.min.js')); ?>"></script>
<!-- magnifiq popup  -->
<script src="<?php echo e(asset('learn/assets/front/js/jquery.magnific-popup.min.js')); ?>"></script>
<!-- owl carousel -->
<script src="<?php echo e(asset('learn/assets/front/js/')); ?>/owl.carousel.min.js"></script>
<!-- main -->
<script src="<?php echo e(asset('learn/assets/front/js/')); ?>/main.js"></script>
<?php echo $__env->yieldContent('script'); ?>
<?php if(session('success')): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            swal("Success!", "<?php echo e(session('success')); ?>", "success");
        });
    </script>
<?php endif; ?>
<?php if(session('alert')): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            swal("Opps!", "<?php echo e(session('alert')); ?>", "error");
        });
    </script>
<?php endif; ?>

<script>
    jQuery(document).on('click', '.mega-dropdown', function (e) {
        e.stopPropagation()
    })
</script>
</body>
</html>

