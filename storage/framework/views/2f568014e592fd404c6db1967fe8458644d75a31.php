<?php $__env->startSection('content'); ?>

<head>
	<title>Laravel </title>
	
     
     <style>
      
     
     </style>
</head>

  
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1 class="text-info offset-1">Login</h1>
                </div>
                <div class="panel-body">
                    <form id="myform" class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/master-admin-login')); ?>">
                        <?php echo csrf_field(); ?>

   
                       
   
                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label class="col-md-4 control-label">Primary E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="primary_email" value="<?php echo e(old('email')); ?>">
                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label class="col-md-4 control-label">Secondary E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="secondary_email" value="<?php echo e(old('email')); ?>">
                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
   
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <br/>
                                <button type="submit"  class="btn btn-primary" >
                                    <i class="fa fa-btn fa-user" onclick="showform()"></i>Next
                               
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