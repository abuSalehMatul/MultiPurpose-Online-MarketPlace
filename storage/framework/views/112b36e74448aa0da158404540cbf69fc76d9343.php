<?php $__env->startSection('content'); ?>

<head>
	<title>Laravel 5.7 - Google Recaptcha Code with Validation - ItSolutionStuff.com</title>
	
	 
</head>

  
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Confirm</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/admin_confirm')); ?>">
                        <?php echo csrf_field(); ?>

   
                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>">
                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
   
                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <label class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" >
                               
                            </div>
                        </div>
                        <div class="form-group<?php echo e($errors->has('pin') ? ' has-error' : ''); ?>">
                            <label class="col-md-4 control-label">Pin</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="pin" >
                               
                            </div>
                        </div>
   
                                
   
                        
   
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <br/>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Confrim
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
   

<?php $__env->stopSection(); ?>
<?php echo $__env->make('master_backend.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>