<!DOCTYPE html>
<html lang="en">
<head>

    <title>{{$basic->sitename}} | {{$page_title}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{asset('learn/assets/images/logo/favicon.png')}}" />


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">


    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('learn/assets/admin/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="{{asset('learn/assets/admin/css/font-awesome.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('learn/assets/admin/css/fontawesome-iconpicker.min.css')}}">
    <link href="{{asset('learn/assets/admin/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <link href="{{asset('learn/assets/admin/css/bootstrap-fileinput.css')}}" rel="stylesheet">
    <link href="{{asset('learn/assets/admin/css/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('learn/assets/admin/css/table.css')}}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" type="text/css" href="{{asset('learn/assets/admin/css/custom.css')}}">


    <script src="{{asset('learn/assets/admin/js/sweetalert.js')}}"></script>
    <link rel="stylesheet" href="{{asset('learn/assets/admin/css/sweetalert.css')}}">
</head>
<body class="app sidebar-mini rtl">
<!-- Navbar-->
<header class="app-header"><a class="app-header__logo" href="{{url('/')}}">{{$basic->sitename}}</a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="{{route('admin.changePass')}}"><i class="fa fa-cog fa-lg"></i> Password Settings</a></li>
                <li><a class="dropdown-item" href="{{route('admin.profile')}}"><i class="fa fa-user fa-lg"></i> Profile</a></li>
                <li><a class="dropdown-item" href="{{url('logout')}}"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</header>
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" class="img-circle" src="{{asset('assets/admin/img/'.Auth::guard('admin')->user()->image)}}" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">{{ Auth::guard('admin')->user()->name }} </p>
            <p class="app-sidebar__user-designation">{{ Auth::guard('admin')->user()->username }}</p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item @if(request()->path() == 'admin/dashboard') active @endif" href="{{route('admin.dashboard')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

        <li class="treeview  @if(request()->path() == 'admin/category')  is-expanded
                        @elseif(request()->path() == 'admin/sub-category')  is-expanded
                        @endif">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Manage Category</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                {{-- <li><a class="treeview-item " href="{{url('admin/category')}}"><i class="icon fa fa-desktop"></i> Category</a></li>
                <li><a  href="{{route('admin.unit')}}"><i class="treeview-item active icon fa fa-th"></i> Sub Category</a></li> --}}
                <li><a class="treeview-item @if(request()->path() == 'admin/learn_category') active @endif" href="{{url('admin/learn_category')}}"><i class="icon fa fa-desktop"></i> Category</a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/sub-category') active @endif" href="{{route('admin.unit')}}"><i class="icon fa fa-th"></i> Sub Category</a></li>

            </ul>
        </li>
        <li class="treeview
                        @if(request()->path() == 'admin/article-create')  is-expanded
                        @elseif(request()->path() == 'admin/articles')  is-expanded
                        @endif">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Manage Post</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item @if(request()->path() == 'admin/article-create') active @endif" href="{{route('plan.create')}}"><i class="icon fa fa-plus"></i> Create Post</a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/articles') active @endif" href="{{route('plan.all')}}"><i class="icon fa fa-desktop"></i> All Posts</a></li>

            </ul>
        </li>

        <li><a class="app-menu__item @if(request()->path() == 'admin/live') active @endif" href="{{route('admin.live')}}"><i class="app-menu__icon fa fa-play-circle"></i><span class="app-menu__label">Manage Live</span></a></li>

        <li class="treeview @if(request()->path() == 'admin/blog-category') is-expanded
                @elseif(request()->path() == 'admin/blog') is-expanded
                @endif ">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-newspaper"></i><span class="app-menu__label">Manage Blog</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item @if(request()->path() == 'admin/blog-category') active @endif" href="{{route('admin.cat')}}"><i class="icon fa fa-pencil"></i>  Category</a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/blog') active @endif" href="{{url('admin/blog')}}"><i class="icon fa fa-newspaper-o"></i> All Blog</a></li>
            </ul>
        </li>
        <li><a class="app-menu__item @if(request()->path() == 'admin/subscribers') active @endif" href="{{route('manage.subscribers')}}"><i class="app-menu__icon fa fa-thumbs-up"></i><span class="app-menu__label">All Subscribers</span></a></li>


        <li class="treeview @if(request()->path() == 'admin/general-settings') is-expanded
                                @elseif(request()->path() == 'admin/template') is-expanded
                                @elseif(request()->path() == 'admin/contact-setting') is-expanded
                            @endif">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-bars"></i><span class="app-menu__label">Website Control</span><i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item @if(request()->path() == 'admin/general-settings') active @endif" href="{{route('admin.GenSetting')}}"><i class="icon fa fa-cogs"></i> General Setting </a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/template') active @endif" href="{{route('email.template')}}"><i class="icon fa fa-envelope"></i> Email Setting</a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/contact-setting') active @endif" href="{{route('contact-setting')}}"><i class="icon fa fa-phone"></i> Contact Setting </a></li>
            </ul>
        </li>


        <li class="treeview     @if(request()->path() == 'admin/manage-logo') is-expanded
                                @elseif(request()->path() == 'admin/manage-footer') is-expanded
                                @elseif(request()->path() == 'admin/manage-social') is-expanded
                                @elseif(request()->path() == 'admin/menu-control') is-expanded
                                @elseif(request()->path() == 'admin/manage-breadcrumb') is-expanded
                                @elseif(request()->path() == 'admin/manage-about') is-expanded
                                @elseif(request()->path() == 'admin/manage-terms') is-expanded
                                @elseif(request()->path() == 'admin/faqs-create') is-expanded
                                @elseif(request()->path() == 'admin/faqs-all') is-expanded
                                @elseif(request()->path() == 'admin/testimonial') is-expanded
                                @elseif(request()->path() == 'admin/our-goals') is-expanded
                            @endif">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-desktop"></i><span class="app-menu__label">Interface Control</span><i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item @if(request()->path() == 'admin/manage-logo') active @endif" href="{{route('manage-logo')}}"><i class="icon fa fa-photo"></i> Logo & favicon </a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/manage-footer') active @endif" href="{{route('manage-footer')}}"><i class="icon fa fa-file-text"></i> Manage Footer & Text </a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/manage-social') active @endif" href="{{route('manage-social')}}"><i class="icon fa fa-share-alt-square"></i> Manage Social </a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/menu-control') active @endif" href="{{route('menu-control')}}"><i class="icon fa fa-desktop"></i> Menu Control </a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/manage-breadcrumb') active @endif" href="{{route('manage-breadcrumb')}}"><i class="icon fa fa-apple"></i> Manage Breadcrumb </a></li
                <li><a class="treeview-item @if(request()->path() == 'admin/manage-about') active @endif" href="{{route('manage-about')}}"><i class="icon fa fa-info-circle"></i> Manage About </a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/testimonial') active @endif" href="{{route('admin.testimonial')}}"><i class="icon fa fa-clipboard"></i> Manage Testimonial </a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/our-goals') active @endif" href="{{route('service-control')}}"><i class="icon fa fa-clipboard"></i> Our Goals </a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/faqs-create') active @endif" href="{{route('faqs-create')}}"><i class="icon fa fa-plus"></i> New Faq </a></li>
                <li><a class="treeview-item @if(request()->path() == 'admin/faqs-all') active @endif" href="{{route('faqs-all')}}"><i class="icon fa fa-photo"></i> Manage Faqs </a></li>
            </ul>
        </li>



    </ul>
</aside>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> {{$page_title}}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        </ul>
    </div>
    @yield('body')



</main>
<!-- Essential javascripts for application to work-->
<script src="{{asset('learn/assets/admin/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('learn/assets/admin/js/popper.min.js')}}"></script>
<script src="{{asset('learn/assets/admin/js/bootstrap.min.js')}}"></script>
<script src="{{asset('learn/assets/admin/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('learn/assets/admin/js/bootstrap-fileinput.js')}}" type="text/javascript"></script>
<script src="{{asset('learn/assets/admin/js/fontawesome-iconpicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('learn/assets/admin/js/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{asset('learn/assets/admin/js/main.js')}}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{asset('learn/assets/admin/js/pace.min.js')}}"></script>
<!-- Page specific javascripts-->
@yield('script')
@if (session('success'))
    <script type="text/javascript">
        $(document).ready(function () {
            swal("Success!", "{{ session('success') }}", "success");
        });
    </script>
@endif

@if (session('alert'))
    <script type="text/javascript">
        $(document).ready(function () {
            swal("Sorry!", "{{ session('alert') }}", "error");
        });
    </script>
@endif
<script type="text/javascript">
            @if(Session::has('message'))
    var type = "{{Session::get('alert-type','info')}}";
    switch (type) {
        case 'info':
            toastr.info("{{Session::get('message')}}");
            break;
        case 'warning':
            toastr.warning("{{Session::get('message')}}");
            break;
        case 'success':
            toastr.success("{{Session::get('message')}}");
            break;
        case 'error':
            toastr.error("{{Session::get('message')}}");
            break;
    }
    @endif
</script>



</body>
</html>