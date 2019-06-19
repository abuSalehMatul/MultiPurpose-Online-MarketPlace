<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="card col-md-10 col-sm-10">
        <div class="card-title col-md-10">
           <h3 class="text-center"> Welcome to KCE.</h3>
        </div>
        <nav class="nav navbar-default">
                                   <?php if(auth()->guard()->guest()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                            </li>
                            <?php if(Route::has('register')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <?php echo e(__('Logout')); ?>

                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                        <?php endif; ?>
        </nav>
        <style>
            .box{
                height: 100px;
                padding:10px;
                margin:20px;
                background: greenyellow;
                color:white;
                font-weight: 800;
                float: left;
            }
        </style>
        <div class="card-body">
            <div class="col-md-3 box">
                <a href="<?php echo e(url('freelancer-dashboard')); ?>">
                    Freelancer
                </a> 
            </div>
            <div class="col-md-3 box">
                Pro
            </div>
            <div class="col-md-3 box">
                Job
            </div>
            <div class="col-md-3 box">
                <a href="<?php echo e(url('/coupon-dashboard')); ?>">
                    Community
                </a>
                
            </div>
            <div class="col-md-3 box">
                <a href="<?php echo e(url('/learn-and-grow')); ?>"> Study and Grow</a>
               
            </div>
             <div class="col-md-3 box">
               Scolarship
            </div>
        </div>
    </div>
</body>
</html>