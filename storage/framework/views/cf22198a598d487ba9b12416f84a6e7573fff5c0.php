<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  
  <!-- favicon-icon -->
  <link rel="icon" type="image/icon" href="<?php echo e(asset('coupon/images/favicon/'.$settings->favicon)); ?>"> 
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">        
  <!-- flaticon css -->
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('coupon/vendor/flaticon/flaticon.css')); ?>"/>
  <link href="<?php echo e(asset('coupon/css/datepicker.css')); ?>" rel="stylesheet" type="text/css"/> 
  <link rel="stylesheet" href="<?php echo e(asset('coupon/css/admin.css')); ?>">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote-bs4.css"/> <!-- summernote css -->
  <!-- Admin (main) Style Sheet -->
</head>
  <body class="hold-transition skin-blue">
<div class="wrapper">
  <!-- Main Header -->
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo e(url('admin')); ?>" class="logo">
      <?php if($settings->logo != Null): ?>
       <img src="<?php echo e(asset('coupon/images/'.$settings->logo)); ?>" alt="logo">
      <?php else: ?>
        <h2 class="logo-title"><?php echo e($settings->w_name ? $settings->w_name : 'Logo'); ?></h2>
      <?php endif; ?>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <a href="<?php echo e(url('/')); ?>" class="visit-site-btn btn" target="_blank">Visit Site <i class="material-icons right">keyboard_arrow_right</i></a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown admin-nav">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="material-icons">account_circle</i></button>
            <ul class="dropdown-menu animated flipInX">
              <li><a href="<?php echo e(url('admin/profile')); ?>">My Profile</a></li>
              <li>
                <a href="<?php echo e(route('logout')); ?>"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo e(csrf_field()); ?>

                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <i class="material-icons">account_circle</i>
        </div>
        <div class="pull-left info">
          <h4 class="user-name"><?php echo e($auth->name); ?></h4>
          <p>Admin</p>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- Optionally, you can add icons to the links -->
        <li><a href="<?php echo e(url('admin')); ?>"><i class="material-icons">dashboard</i> <span>Dashboard</span></a></li>                    
        <li class="treeview">
          <a href="#" class="<?php echo e(Nav::isResource('category')); ?>">
            <i class="material-icons">category</i> <span>Category</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo e(url('admin/category/create')); ?>"><i class="material-icons">label_outline</i> Add Category</a></li>
            <li><a href="<?php echo e(route('category.index')); ?>"><i class="material-icons">label_outline</i> All Categorry</a></li>
          </ul>
        </li> 
        <li class="treeview">
          <a href="#" class="<?php echo e(Nav::isResource('store')); ?>">
            <i class="material-icons">store</i> <span>Store</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo e(url('admin/store/create')); ?>"><i class="material-icons">label_outline</i> Add Store</a></li>
            <li><a href="<?php echo e(route('store.index')); ?>"><i class="material-icons">label_outline</i> All Store</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#" class="<?php echo e(Nav::isResource('forumcategory')); ?>">
            <i class="material-icons">forum</i> <span>Forum Category</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo e(url('admin/forumcategory/create')); ?>"><i class="material-icons">label_outline</i>Add Forum Category</a></li>
            <li><a href="<?php echo e(route('forumcategory.index')); ?>"><i class="material-icons">label_outline</i> All Forum Category</a></li>
          </ul>
        </li> 
        <li class="treeview">
          <a href="#" class="<?php echo e(Nav::isResource('coupon')); ?>">
            <i class="material-icons">card_giftcard</i> <span>Coupon & Deal</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo e(url('admin/coupon/create')); ?>"><i class="material-icons">label_outline</i>Add Coupon & Deal</a></li>
            <li><a href="<?php echo e(route('coupon.index')); ?>"><i class="material-icons">label_outline</i> All Coupon & Deal</a></li>
          </ul>
        </li> 
        <li class="treeview">
          <a href="#" class="<?php echo e(Nav::isResource('discussion')); ?>">
            <i class="material-icons">chat</i> <span>Discussion</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo e(url('admin/discussion/create')); ?>"><i class="material-icons">label_outline</i>Add Discussion</a></li>
            <li><a href="<?php echo e(route('discussion.index')); ?>"><i class="material-icons">label_outline</i> All Discussion</a></li>
          </ul>
        </li>
        <li><a href="<?php echo e(url('admin/comment')); ?>"><i class="material-icons">chat</i> <span>Comments</span></a></li>                    
        <li class="treeview">
          <a href="#" class="<?php echo e(Nav::isResource('user')); ?>">
            <i class="material-icons">people</i> <span>User</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo e(url('admin/user/create')); ?>"><i class="material-icons">label_outline</i>Add User</a></li>
            <li><a href="<?php echo e(route('user.index')); ?>"><i class="material-icons">label_outline</i> All User</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#" class="<?php echo e(Nav::isResource('blog')); ?>">
            <i class="material-icons">pages</i> <span>Blog</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo e(url('admin/tag')); ?>"><i class="material-icons">label_outline</i><span>Blog Tags</span></a></li> 
            <li><a href="<?php echo e(url('admin/blog/create')); ?>"><i class="material-icons">label_outline</i> Add Blog</a></li>
            <li><a href="<?php echo e(route('blog.index')); ?>"><i class="material-icons">label_outline</i>All Blogs</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#" class="<?php echo e(Nav::isResource('faq')); ?>">
            <i class="material-icons">live_help</i> <span>FAQ</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo e(route('faqcategory.index')); ?>"><i class="material-icons">label_outline</i> FAQ Category</a></li>
            <li><a href="<?php echo e(route('faq.index')); ?>"><i class="material-icons">label_outline</i>FAQ</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#" class="<?php echo e(Nav::isResource('pages')); ?>">
            <i class="material-icons">pages</i> <span>Pages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo e(url('admin/pages/create')); ?>"><i class="material-icons">label_outline</i> Add Pages</a></li>
            <li><a href="<?php echo e(route('pages.index')); ?>"><i class="material-icons">label_outline</i>All Pages</a></li>
          </ul>
        </li>
        <li><a class="<?php echo e(Nav::isResource('slider')); ?>" href="<?php echo e(url('admin/slider')); ?>"><i class="material-icons">image</i> Home Banner</a></li>
        <li class="treeview">
          <a href="#" class="<?php echo e(Nav::isResource('setting')); ?>">
            <i class="material-icons">build</i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo e(url('admin/settings')); ?>"><i class="material-icons">label_outline</i> General Settings</a></li>
            <li><a href="<?php echo e(route('social.index')); ?>"><i class="material-icons">label_outline</i>Social</a></li>
            
          </ul>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
    <!-- Main content -->
    <section class="content container-fluid">
      <?php if(Session::has('added')): ?>
        <div id="sessionModal" class="sessionmodal rgba-green-strong z-depth-2">
          <i class="fa fa-check-circle"></i> <p><?php echo e(session('added')); ?></p>
        </div>
      <?php elseif(Session::has('updated')): ?>
        <div id="sessionModal" class="sessionmodal rgba-cyan-strong z-depth-2">
          <i class="fa fa-check-circle"></i> <p><?php echo e(session('updated')); ?></p>
        </div>
      <?php elseif(Session::has('deleted')): ?>
        <div id="sessionModal" class="sessionmodal rgba-red-strong z-depth-2">
          <i class="fa fa-window-close"></i> <p><?php echo e(session('deleted')); ?></p>
        </div>
      <?php endif; ?>
      <?php echo $__env->yieldContent('content'); ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Main Footer -->
</div>
<!-- ./wrapper -->
<!-- Admin Js -->
<script src="<?php echo e(asset('js/jquery-3.3.1.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/admin.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('vendor/summernote/js/summernote-bs4.min.js')); ?>"></script>
<!-- summernote js -->
<script src="<?php echo e(asset('js/datatables.min.js')); ?>" type="text/javascript"></script>
    <!-- Datepicker Library -->
<script src="<?php echo e(asset('js/datepicker.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/utils.js')); ?>" type="text/javascript"></script>
<script>
  $(function () {
    $('#flash-overlay-modal').modal();
    $('.alert').addClass('active');
    $('.alert').addClass('z-depth-1');
    setTimeout(function(){
      $('.alert:not(.alert-important)').removeClass('active');
    }, 6000);  
    $( '.date-picker' ).datepicker({
        format : "yyyy-mm-dd",
        startDate: '+1d',
       autoclose: true,
      });
    // DataTables
    $('#movies_table').DataTable({
      responsive: true,
      "sDom": "<'row'><'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>r>t<'row'<'col-sm-12'p>>",
      "language": {
        "paginate": {
          "previous": '<i class="material-icons paginate-btns">keyboard_arrow_left</i>',
          "next": '<i class="material-icons paginate-btns">keyboard_arrow_right</i>'
          }
      },
      buttons: [
        {
          extend: 'print',
          exportOptions: {
              columns: ':visible'
          }
        },
        'csvHtml5',
        'excelHtml5',
        'colvis',
      ]
    });

    $('#full_detail_table').DataTable({
      "sDom": "<'row'><'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>r>t<'row'<'col-sm-12'p>>",
      "language": {
      "paginate": {
        "previous": '<i class="material-icons paginate-btns">keyboard_arrow_left</i>',
        "next": '<i class="material-icons paginate-btns">keyboard_arrow_right</i>'
        }
      },
      buttons: [
        {
          extend: 'print',
          exportOptions: {
              columns: ':visible'
          }
        },
        'csvHtml5',
        'excelHtml5',
        'colvis',
      ]
    });

    $('#summernote-main').summernote({
      height: 100,
    });

    $(".js-select2").select2({
        placeholder: "Pick states",
        theme: "material"
    });
    
    $(".select2-selection__arrow")
        .addClass("material-icons")
        .html("arrow_drop_down");
  });
</script>
<?php echo $__env->yieldContent('custom-script'); ?>
</body>
</html>

