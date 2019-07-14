<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$page_title}} | {{$basic->sitename}} </title>
    <!-- favicon -->
    <link rel="icon" type="image/png" href="{{asset('learn/assets/images/logo/favicon.png')}}"/>
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('learn/assets/front/css/bootstrap.min.css')}}">

    <!-- stylesheet -->
    <link rel="stylesheet" href="{{asset('learn/assets/front/css/owl.carousel.css')}}">
    <!-- fontawesome -->

    <link rel="stylesheet" href="{{asset('learn/assets/front/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- slicknav -->
    <link rel="stylesheet" href="{{asset('learn/assets/front/css/slicknav.min.css')}}">
    <!-- jquery ui css -->
    <link rel="stylesheet" href="{{asset('learn/assets/front/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('learn/assets/front/css/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('learn/assets/front/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('learn/assets/front/css/custom-menu.css')}}">
    @yield('css')
    <link rel="stylesheet" type="text/css" href="{{asset('learn/assets/front/css/style.php')}}?color={{ $basic->color }}">
    <link rel="stylesheet" type="text/css" href="{{asset('learn/assets/front/css/style2.php')}}?color2={{ $basic->color2 }}">
    <link rel="stylesheet" type="text/css" href="{{asset('learn/assets/front/css/hover.php')}}?hover={{ $basic->hover }}">
    <!-- responsive -->
    <link rel="stylesheet" href="{{asset('learn/assets/front/css/responsive.css')}}">

</head>
<body>


<!-- support bar area start -->
<div class="support-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <a href="{{route('learn.homepage')}}" class="logo">
                    <img src="{{asset('learn/assets/images/logo/logo.png')}}" alt="logo">
                </a>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
                <div class="support-right">
                    <div class="single-support-box">
                        <h3>{!! $basic->short_heading !!}</h3>
                        <p>{!! $basic->short_notes !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="support-btn">
                    <a href="{{route('live.class')}}" class="boxed-btn pointer">Live Class</a>
                </div>
            </div>
        </div>
    </div>
</div> <!--end support bar area -->


@yield('content')





<!-- footer area start -->
<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 width-50">
                <div class="widget-area">
                    <div class="widget-header">
                        <a href="{{url('/')}}" class="logo">
                            <img src="{{asset('assets/images/logo/logo.png')}}" alt="logo image">
                        </a>
                    </div>
                    <div class="widget-body">
                        <p>{!! $basic->breadcrumb_text !!}</p>
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
                                    <li><a href="{{url('/')}}">Home</a></li>
                                    @foreach($menus as $menu)
                                        <li><a href="{{route('menu',$menu->slug)}}">{{$menu->name}}</a></li>
                                    @endforeach
                                    <li><a href="{{route('about')}}">About Us</a></li>
                                    <li><a href="{{route('faqs')}}">Faqs</a></li>
                                    <li><a href="{{route('contact')}}">Contact Us</a></li>
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
                                    @foreach($postCategoryNull as $data)
                                        @php
                                            $slug = str_slug($data->name);
                                        @endphp
                                        <li>
                                            <a href="{{route('article.categories',[$data->id, $slug])}}">{{$data->name or '-'}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="widget-area">
                            <div class="widget-header empty-title"></div>
                            <div class="widget-body">
                                <ul>

                                    @foreach($postCategoryNotNull as $data)
                                        @php
                                            $slug = str_slug($data->name);
                                        @endphp
                                        <li><a href="{{route('article.categories',[$data->id, $slug])}}">{{$data->short_name or $data->name}}</a></li>
                                    @endforeach
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
                            @foreach($social as $data)
                                <li><a href="{{$data->link}}">{!! $data->code !!} {{$data->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- jquery -->
<script src="{{asset('learn/assets/front/js/jquery.js')}}"></script>
<!-- bootstrap -->
<script src="{{asset('learn/assets/front/js/bootstrap.min.js')}}"></script>
<!-- slicknav -->
<script src="{{asset('learn/assets/front/js/jquery.slicknav.min.js')}}"></script>
<!-- imagesloaded -->
<script src="{{asset('learn/assets/front/js/imagesloaded.pkgd.min.js')}}"></script>
<!-- jqury ui  -->
<script src="{{asset('learn/assets/front/js/jquery-ui.js')}}"></script>
<script src="{{asset('learn/assets/front/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('learn/assets/front/js/sweetalert.js')}}"></script>
<!-- isotope -->
<script src="{{asset('learn/assets/front/js/isotope.pkgd.min.js')}}"></script>
<!-- magnifiq popup  -->
<script src="{{asset('learn/assets/front/js/jquery.magnific-popup.min.js')}}"></script>
<!-- owl carousel -->
<script src="{{asset('learn/assets/front/js/')}}/owl.carousel.min.js"></script>
<!-- main -->
<script src="{{asset('learn/assets/front/js/')}}/main.js"></script>
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
            swal("Opps!", "{{ session('alert') }}", "error");
        });
    </script>
@endif

<script>
    jQuery(document).on('click', '.mega-dropdown', function (e) {
        e.stopPropagation()
    })
</script>
</body>
</html>

