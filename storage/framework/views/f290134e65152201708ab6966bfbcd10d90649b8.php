
<div class="menubar-m">
<?php
    $articleCategory=App\Model\Mining::where('status',1)->get();
?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <nav class="navbar navbar-default navbar-custom-bg">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse"
                                data-target=".js-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>


                    <div class="collapse navbar-collapse js-navbar-collapse">
                        <ul class="nav navbar-nav nav-position">
                            <?php $__currentLoopData = $articleCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <li class="dropdown mega-dropdown <?php if( isset($cat_id) && $cat_id == $data->id ): ?> open <?php elseif(!isset($cat_id) && $k == 0): ?> open  <?php endif; ?>" id="cat_<?php echo e($data->id); ?>">
                                    <a href="#" class="dropdown-toggle"
                                       data-toggle="dropdown"><?php echo e($data->short_name or $data->name); ?></a>
                                    <ul class="dropdown-menu mega-dropdown-menu row">

                                        <?php
                                            $subCategory =  $data->subcategory()->get();
                                            $slug =  str_slug($data->name);
                                        ?>

                                        <?php $__currentLoopData = $subCategory->chunk(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="col-md-3 col-sm-6 col-xs-12">
                                                <ul>
                                                    <?php $__currentLoopData = $cc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><a href="<?php echo e(route('topics',[$c->id,$slug])); ?>"><?php echo e($c->title); ?>  </a></li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </ul>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </nav>

            </div>
        </div>

    </div>

</div>