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
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('adminpanel/')); ?>/assets/images/favicon.png">
    <title><?php echo e(env('APP_NAME')); ?> - <?php echo e($title); ?></title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="<?php echo e(asset('adminpanel/')); ?>/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('adminpanel/')); ?>/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('adminpanel/')); ?>/assets/libs/morris.js/morris.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo e(asset('adminpanel/')); ?>/dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php echo $__env->yieldPushContent('dashboardcss'); ?>
    <?php echo $__env->yieldPushContent('packagecss'); ?>
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
                        <img src="<?php echo e(asset('adminpanel/')); ?>/assets/images/logo-icon.png" alt="homepage"
                             class="dark-logo"/>
                        <!-- Light Logo icon -->
                        <img src="<?php echo e(asset('adminpanel/')); ?>/assets/images/logo-light-icon.png" alt="homepage"
                             class="light-logo"/>
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="<?php echo e(asset('adminpanel/')); ?>/assets/images/logo-text.png" alt="homepage"
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
                            <div class="user-content hide-menu m-t-10">
                                <h5 class="m-b-0"><?php echo e(Auth::user()->name); ?></h5>
                                <a href="javascript:void(0)" class="btn btn-circle btn-sm m-r-5" id="Userdd"
                                   role="button" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="ti-settings"></i>
                                </a>
                                <a href="<?php echo e(route('logout')); ?>" title="Logout" class="btn btn-circle btn-sm">
                                    <i class="ti-power-off"></i>
                                </a>
                                <div class="dropdown-menu animated flipInY" aria-labelledby="Userdd">
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>">
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
                        <a href="<?php echo e(route('sdashboard')); ?>" class="sidebar-link">
                            <i class="icon-Record"></i>
                            <span class="hide-menu">Dashboard</span></a></li>
                    <li class="sidebar-item"><a href="<?php echo e(route('user')); ?>" class="sidebar-link">
                            <i class="icon-Record"></i>
                            <span class="hide-menu">User</span></a></li>
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
    <?php echo $__env->yieldContent('content'); ?>
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
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- apps -->
<script src="<?php echo e(asset('adminpanel/')); ?>/dist/js/app.min.js"></script>
<script src="<?php echo e(asset('adminpanel/')); ?>/dist/js/app.init.js"></script>
<script src="<?php echo e(asset('adminpanel/')); ?>/dist/js/app-style-switcher.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="<?php echo e(asset('adminpanel/')); ?>/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?php echo e(asset('adminpanel/')); ?>/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="<?php echo e(asset('adminpanel/')); ?>/dist/js/custom.min.js"></script>
<!--This page JavaScript -->
<!--chartis chart-->
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/libs/chartist/dist/chartist.min.js"></script>
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<!--c3 charts -->
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/extra-libs/c3/d3.min.js"></script>
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/extra-libs/c3/c3.min.js"></script>
<!--chartjs -->
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/libs/raphael/raphael.min.js"></script>
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/libs/morris.js/morris.min.js"></script>

<?php echo $__env->yieldPushContent('dashboard'); ?>
<?php echo $__env->yieldPushContent('packagejs'); ?>
<?php echo $__env->yieldPushContent('newProductjs'); ?>
</body>
</html>
<?php /**PATH D:\laragon\www\realmlogostics\resources\views/adminpanel/layout/app.blade.php ENDPATH**/ ?>