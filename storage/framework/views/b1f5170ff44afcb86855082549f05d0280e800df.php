<?php if(Schema::hasTable('pages') || Schema::hasTable('site_managements')): ?>
    <?php
        $settings = array();
        $pages = App\Page::all();
        $setting = \App\SiteManagement::getMetaValue('settings');
        $logo = !empty($setting[0]['logo']) ? Helper::getHeaderLogo($setting[0]['logo']) : '/images/logo.png';
        $inner_header = !empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' ? 'wt-headervtwo' : '';
    ?>
<?php endif; ?>
<?php
    if(Auth::user()->hasRole('admin')){
        Auth::user()->syncRoles('admin');
    }else{
        Auth::user()->syncRoles('freelancer');
    }
   
    
?>
<header id="wt-header" class="wt-header wt-haslayout <?php echo e($inner_header); ?>">
    <div class="wt-navigationarea">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php if(auth()->guard()->check()): ?>
                        <?php echo e(Helper::displayEmailWarning()); ?>

                    <?php endif; ?>
                    <?php if(!empty($logo) || Schema::hasTable('site_managements')): ?>
                        <strong class="wt-logo"><a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset($logo)); ?>" alt="<?php echo e(trans('Logo')); ?>"></a></strong>
                    <?php endif; ?>
                    <?php if(!empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' && Route::getCurrentRoute()->uri() != 'home'): ?>
                        <search-form
                        :placeholder="'<?php echo e(trans('lang.looking_for')); ?>'"
                        :freelancer_placeholder="'<?php echo e(trans('lang.search_filter_list.freelancer')); ?>'"
                        :employer_placeholder="'<?php echo e(trans('lang.search_filter_list.employers')); ?>'"
                        :job_placeholder="'<?php echo e(trans('lang.search_filter_list.jobs')); ?>'"
                        :no_record_message="'<?php echo e(trans('lang.no_record')); ?>'"
                        >
                        </search-form>
                    <?php endif; ?>
                    <div class="wt-rightarea">
                        <nav id="wt-nav" class="wt-nav navbar-expand-lg">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="lnr lnr-menu"></i>
                            </button>
                            <div class="collapse navbar-collapse wt-navigation" id="navbarNav">
                                <ul class="navbar-nav">
                                    <?php if(!empty($pages) || Schema::hasTable('pages')): ?>
                                        <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $page_has_child = App\Page::pageHasChild($page->id); $pageID = Request::segment(2);
                                                $show_page = \App\SiteManagement::where('meta_key', 'show-page-'.$page->id)->select('meta_value')->pluck('meta_value')->first();
                                            ?>
                                            <?php if($page->relation_type == 0 && $show_page == 'true'): ?>
                                                <li class="<?php echo e(!empty($page_has_child) ? 'menu-item-has-children page_item_has_children' : ''); ?> <?php if($pageID == $page->slug ): ?> current-menu-item <?php endif; ?>">
                                                    <a href="<?php echo e(url('page/'.$page->slug)); ?>"><?php echo e($page->title); ?></a>
                                                    <?php if(!empty($page_has_child)): ?>
                                                        <ul class="sub-menu">
                                                            <?php $__currentLoopData = $page_has_child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $child = App\Page::getChildPages($parent->child_id);?>
                                                                <li class="<?php if($pageID == $child->slug ): ?> current-menu-item <?php endif; ?>">
                                                                    <a href="<?php echo e(url('page/'.$child->slug.'/')); ?>">
                                                                        <?php echo e($child->title); ?>

                                                                    </a>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <li>
                                        <a href="<?php echo e(url('search-results?type=freelancer')); ?>">
                                            <?php echo e(trans('lang.view_freelancers')); ?>

                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="<?php echo e(url('search-results?type=employer')); ?>">
                                            <?php echo e(trans('lang.view_employers')); ?>

                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('search-results?type=job')); ?>">
                                            <?php echo e(trans('lang.browse_project')); ?>

                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                        
                        <?php if(auth()->guard()->check()): ?>
                            <?php
                                $user = !empty(Auth::user()) ? Auth::user() : '';
                                $role = !empty($user) ? $user->getRoleNames()->first() : array();
                                $profile = \App\User::find($user->id)->profile;
                                $user_image = !empty($profile) ? $profile->avater : '';
                                $employer_job = \App\Job::select('status')->where('user_id', Auth::user()->id)->first();
                                $profile_image = !empty($user_image) ? '/uploads/users/'.$user->id.'/'.$user_image : 'images/user-login.png';
                            ?>
                                <div class="wt-userlogedin">
                                    <figure class="wt-userimg">
                                        <img src="<?php echo e(asset($profile_image)); ?>" alt="<?php echo e(trans('lang.user_avatar')); ?>">
                                    </figure>
                                    <div class="wt-username">
                                        <h3><?php echo e(Helper::getUserName(Auth::user()->id)); ?></h3>
                                        <span><?php echo e(!empty(Auth::user()->profile->tagline) ? str_limit(Auth::user()->profile->tagline, 26, '') : Auth::user()->getRoleNames()->first()); ?></span>
                                    </div>
                                    <?php echo $__env->make('back-end.includes.profile-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </div>
                        <?php endif; ?>
                        <?php if(!empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' && Route::getCurrentRoute()->uri() != 'home'): ?>
                            <div class="wt-respsonsive-search"><a href="javascript:;" class="wt-searchbtn"><i class="fa fa-search"></i></a></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
