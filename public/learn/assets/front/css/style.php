<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here

function checkhexcolor($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}

?>


@import url('https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i');

h1, h2, h3, h4, h5, h6 {
color: <?php echo $color; ?>;
}

.support-bar {
background: <?php echo $color; ?>;
}

.footer-area .widget-area .widget-body li a:hover{
color: <?php echo $color; ?>;
}

.subscription-area .subscription-form .form-wrappe input[type=submit],
.subscription-area .subscription-form .form-wrappe input[type=submit]:hover
{
background-color:  <?php echo $color; ?>;
}

.subscription-area .subscription-form {
border: 2px solid <?php echo $color; ?>;
}


.navbar-default .navbar-nav > li > a {
color:  <?php echo $color; ?> !important;
}

.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:focus, .navbar-default .navbar-nav > .open > a:hover {
color: #FFF !important;
background-color:<?php echo $color; ?> !important;
}

.navbar-nav > li > .dropdown-menu {
border-top: 3px solid <?php echo $color; ?> !important;
}

.singl-contact-info .icon {
color: <?php echo $color; ?> !important;
}


.submit-form-btn {
background-color: <?php echo $color; ?> !important;
}

.panel-title-bg{
background-color: <?php echo $color; ?> !important;
border:  <?php echo $color; ?> !important;
}
.m-t-50{
margin-top: -50px;
}
.font-20{
    font-size: 20px;
}

.panel-heading-custom,
.panel-heading-custom:hover
{
background: <?php echo $color; ?>;
border: 1px solid <?php echo $color; ?> ;
}

.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
color: #fff;
background-color: <?php echo $color; ?>;
}

.nav-tabs>li>a:hover {
border-color: <?php echo $color; ?> <?php echo $color; ?> <?php echo $color; ?>;
color: <?php echo $color; ?>;
}

.navbar-default .navbar-toggle .icon-bar{
background-color: <?php echo $color; ?>;
}
.navbar-toggle {
 background-color: #ddd;
}
.vacation-area .single-vacation-item:hover .icon {
border-color: <?php echo $color; ?>;
}
.support-right {
text-align: center;
}
.single-support-box h3{
color: #fff;
}
.single-support-box p{
color: #fff;
}

.mega-dropdown-menu > li > ul > li > a {
display: block;
padding: 10px 20px;
clear: both;
font-weight: normal;
line-height: 1.428571429;
color: <?php echo $color; ?>;
white-space: normal;
font-size: 16px;
}

.mega-dropdown-menu > li > ul > li > a:hover{
background: transparent;
color: <?php echo $color; ?>;
text-decoration: underline;
}


.navbar-default .navbar-nav > li > a:hover {
background: <?php echo $color; ?>;
color: #ffffff !important;
}

.blog-page-area .single-blog-post .content .left-content .post-meta {
background-color: <?php echo $color; ?>;
}


.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
    z-index: 3;
    color: #fff;
    cursor: default;
    background-color:<?php echo $color; ?>;
    border-color:<?php echo $color; ?>
}


.pagination>li>a, .pagination>li>span {
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: <?php echo $color; ?>;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid <?php echo $color; ?>;
}


.pagination>.disabled>a, .pagination>.disabled>a:focus, .pagination>.disabled>a:hover, .pagination>.disabled>span, .pagination>.disabled>span:focus, .pagination>.disabled>span:hover {
    color:  <?php echo $color; ?>;
    cursor: not-allowed;
    background-color: #fff;
    border-color: <?php echo $color; ?>;
}


