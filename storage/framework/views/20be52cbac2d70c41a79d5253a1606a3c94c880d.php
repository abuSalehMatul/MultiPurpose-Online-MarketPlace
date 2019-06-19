<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('learn/assets/front/css/homepage.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>


    <?php echo $__env->make('learn.partials.menubar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- vacation of your dream area start -->
    <section class="vacation-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="section-title">
                        <h2><strong><?php echo e($basic->goal_heading); ?></strong></h2>
                        <p><?php echo $basic->goal_para; ?></p>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <?php $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="single-vacation-item">
                            <div class="icon">
                                <img src="<?php echo e(asset('learn/assets/images/'.$data->image)); ?>" class="m-t-50"
                                     alt="...">
                            </div>
                            <div class="content">
                                <a>
                                    <h4> <?php echo e($data->title); ?></h4>
                                </a>
                                <p><?php echo $data->details; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <!-- vacation of your dream area end -->





    <!-- news updates start -->
    <section class="news-update-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="section-title">
                        <h2><strong>Our</strong> Blog</h2>
                    </div>
                </div>
            </div>
            <?php $__currentLoopData = $blogs->chunk(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row">
                <?php $__currentLoopData = $blog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-sm-6">
                    <div class="single-news-item">
                        <?php
                            $slug = str_slug($data->title);
                        ?>

                        <a href="<?php echo e(route('details.blog',[$data->id,$slug])); ?>">
                            <img src="<?php echo e(asset('learn/assets/images/post/'.$data->image)); ?>" alt="">
                        </a>

                        <div class="content">
                            <span class="meta-time"><?php echo e(date('d F Y',strtotime($data->created_at))); ?></span><br>
                            <a href="<?php echo e(route('details.blog',[$data->id,$slug])); ?>">
                                <h4><?php echo e($data->title); ?></h4>
                            </a>
                        </div>
                    </div>
                </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
                <br>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </div>
    </section>
    <!-- news updates end -->




















    <div class="parallax section overlay" data-stellar-background-ratio="0.5"
         style="background-image:url('assets/images/logo/testimonial.jpg'); background-position: 0px 66.4844px">

        <div class="container">

            <div class="row">

                <div class="col-md-12">
                    <div class="row testimonials">

                        <div class="owl-carousel owl-theme">
                            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="single-testimonial-item">
                                    <blockquote>
                                        <p class="clients-words"><?php echo $testimonial->details; ?></p>
                                        <span class="clients-name text-primary">— <?php echo e($testimonial->name); ?></span>
                                        <img class="img-circle img-thumbnail"
                                             src="<?php echo e(asset('learn/assets/images/testimonial/'.$testimonial->image)); ?>"
                                             alt="<?php echo e($testimonial->name); ?>">
                                    </blockquote>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div><!--/.col-->
            </div><!--/.row-->
        </div><!-- end container -->
    </div><!-- end section -->

    <?php echo $__env->make('learn.partials.subscribe', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('learn.layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>