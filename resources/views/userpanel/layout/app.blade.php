<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('adminpanel/')}}/assets/images/favicon.png">
    <title>{{ env('APP_NAME') }} - {{$title}}</title>
    <!-- Custom CSS -->
    <link href="{{asset('adminpanel/')}}/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- Custom CSS -->
    <link href="{{asset('adminpanel/')}}/dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @stack('dashboardcss')
    @stack('packagecss')
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                    <i class="ti-menu ti-close"></i>
                </a>
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <a class="navbar-brand" href="index.html">
                    <!-- Logo icon -->
                    <b class="logo-icon">
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <img src="{{asset('adminpanel/')}}/assets/images/logo-icon.png" alt="homepage"
                             class="dark-logo"/>
                        <!-- Light Logo icon -->
                        <img src="{{asset('adminpanel/')}}/assets/images/logo-light-icon.png" alt="homepage"
                             class="light-logo"/>
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="{{asset('adminpanel/')}}/assets/images/logo-text.png" alt="homepage"
                                 class="dark-logo"/>
                        </span>
                </a>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                   data-toggle="collapse" data-target="#navbarSupportedContent"
                   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="ti-more"></i>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left mr-auto">
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                           data-sidebartype="mini-sidebar">
                            <i class="sl-icon-menu font-20"></i>
                        </a>
                    </li>
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Comment -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="ti-bell font-20"></i>

                        </a>
                        <div class="dropdown-menu mailbox animated bounceInDown">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                            <ul class="list-style-none">
                                <li>
                                    <div class="drop-title bg-primary text-white">
                                        <h4 class="m-b-0 m-t-5">4 New</h4>
                                        <span class="font-light">Notifications</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="message-center notifications">
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-danger btn-circle">
                                                    <i class="fa fa-link"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Luanch Admin</h5>
                                                <span class="mail-desc">Just see the my new admin!</span>
                                                <span class="time">9:30 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-success btn-circle">
                                                    <i class="ti-calendar"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Event today</h5>
                                                <span class="mail-desc">Just a reminder that you have event</span>
                                                <span class="time">9:10 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-info btn-circle">
                                                    <i class="ti-settings"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Settings</h5>
                                                <span class="mail-desc">You can customize this template as you want</span>
                                                <span class="time">9:08 AM</span>
                                            </div>
                                        </a>
                                        <!-- Message -->
                                        <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-primary btn-circle">
                                                    <i class="ti-user"></i>
                                                </span>
                                            <div class="mail-contnet">
                                                <h5 class="message-title">Pavan kumar</h5>
                                                <span class="mail-desc">Just see the my admin!</span>
                                                <span class="time">9:02 AM</span>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center m-b-5" href="javascript:void(0);">
                                        <strong>Check all notifications</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- End Comment -->
                    <!-- ============================================================== -->
                </ul>
                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-right">
                    <!-- ============================================================== -->
                    <!-- Search -->
                    <!-- ============================================================== -->
                    <li class="nav-item search-box">
                        <a class="nav-link waves-effect waves-dark" href="javascript:void(0)">
                            <i class="ti-search font-16"></i>
                        </a>
                        <form class="app-search position-absolute">
                            <input type="text" class="form-control" placeholder="Search &amp; enter">
                            <a class="srh-btn">
                                <i class="ti-close"></i>
                            </a>
                        </form>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                           data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <img src="{{asset('adminpanel/')}}/assets/images/users/1.jpg" alt="user"
                                 class="rounded-circle" width="31">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                            <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                <div class="">
                                    <img src="{{asset('adminpanel/')}}/assets/images/users/1.jpg" alt="user"
                                         class="img-circle" width="60">
                                </div>
                                <div class="m-l-10">
                                    <h4 class="m-b-0">{{Auth::user()->name}}</h4>
                                    <p class=" m-b-0">{{Auth::user()->email}}</p>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('logout')}}">
                                <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                            <div class="dropdown-divider"></div>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <!-- User Profile-->
                    <li>
                        <!-- User Profile-->
                        <div class="user-profile dropdown m-t-20">
                            <div class="user-pic">
                                <img src="{{asset('adminpanel/')}}/assets/images/users/1.jpg" alt="users"
                                     class="rounded-circle img-fluid"/>
                            </div>
                            <div class="user-content hide-menu m-t-10">
                                <h5 class="m-b-10 user-name font-medium">{{Auth::user()->name}}</h5>
                                <a href="javascript:void(0)" class="btn btn-circle btn-sm m-r-5" id="Userdd"
                                   role="button" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="ti-settings"></i>
                                </a>
                                <a href="{{route('logout')}}" title="Logout" class="btn btn-circle btn-sm">
                                    <i class="ti-power-off"></i>
                                </a>
                                <div class="dropdown-menu animated flipInY" aria-labelledby="Userdd">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{route('logout')}}">
                                        <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                </div>
                            </div>
                        </div>
                        <!-- End User Profile-->
                    </li>

                    <!-- User Profile-->
                    <li class="nav-small-cap">
                        <i class="mdi mdi-dots-horizontal"></i>
                        <span class="hide-menu">Personal</span>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('dashboard')}}" class="sidebar-link" {{(Request::instance()->query('packageStatus') == true)? "style=display:none":''}}>
                            <i class="icon-Record"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('product')}}" class="sidebar-link" {{(Request::instance()->query('packageStatus') == true)? "style=display:none":''}}>
                            <i class="icon-Record"></i>
                            <span class="hide-menu">Product</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('dchat')}}" class="sidebar-link" {{(Request::instance()->query('packageStatus') == true)? "style=display:none":''}}>
                            <i class="icon-Record"></i>
                            <span class="hide-menu">Chat</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('order')}}" class="sidebar-link" {{(Request::instance()->query('packageStatus') == true)? "style=display:none":''}}>
                            <i class="icon-Record"></i>
                            <span class="hide-menu">Order</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('stock')}}" class="sidebar-link" {{(Request::instance()->query('packageStatus') == true)? "style=display:none":''}}>
                            <i class="icon-Record"></i>
                            <span class="hide-menu">Stock</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('sales-report')}}" class="sidebar-link" {{(Request::instance()->query('packageStatus') == true)? "style=display:none":''}}>
                            <i class="icon-Record"></i>
                            <span class="hide-menu">Sales Report</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                           aria-expanded="false">
                            <i class="icon-Car-Wheel"></i>
                            <span class="hide-menu">Setting </span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="{{route('packages')}}" class="sidebar-link"> <i
                                            class="icon-Record"></i><span class="hide-menu">Buy Package</span></a></li>
                            <li class="sidebar-item"><a href="{{route('deposit')}}" class="sidebar-link" > <i
                                            class="icon-Record"></i><span class="hide-menu">Buy Deposit</span></a></li>
                            <li class="sidebar-item"><a href="{{route('market')}}" class="sidebar-link"  {{(Request::instance()->query('packageStatus') == true)? "style=display:none":''}}> <i
                                            class="icon-Record"></i><span class="hide-menu"> Market Places</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
    @yield('content')
    <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
            All Rights Reserved by AdminBite admin. Designed and Developed by
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- customizer Panel -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{asset('adminpanel/')}}/assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{asset('adminpanel/')}}/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="{{asset('adminpanel/')}}/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- apps -->
<script src="{{asset('adminpanel/')}}/dist/js/app.min.js"></script>
<script src="{{asset('adminpanel/')}}/dist/js/app.init.js"></script>
<script src="{{asset('adminpanel/')}}/dist/js/app-style-switcher.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{asset('adminpanel/')}}/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="{{asset('adminpanel/')}}/assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="{{asset('adminpanel/')}}/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="{{asset('adminpanel/')}}/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="{{asset('adminpanel/')}}/dist/js/custom.min.js"></script>
<!--This page JavaScript -->
<!--chartis chart-->
<script src="{{asset('adminpanel/')}}/assets/libs/chartist/dist/chartist.min.js"></script>
<script src="{{asset('adminpanel/')}}/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<!--chartjs -->

@stack('dashboard')
@stack('packagejs')
@stack('newProductjs')
</body>
</html>
