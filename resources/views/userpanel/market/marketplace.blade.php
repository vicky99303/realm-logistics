@extends('userpanel.layout.app')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">

                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Info box -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Marketplace List</h4>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="widget-stat card">
                                        <div class="card-body p-4">
                                            <a href="{{route('tokopedia',['slug'=>(isset($slug)?$slug:'')])}}">
                                                    <span class="mr-3 bgl-primary text-primary">
                                                        <!-- <i class="ti-user"></i> -->
                                                        <img src="{{asset('adminpanel/images/marketplace/tokopedia.png')}}"
                                                             alt="tokopedia-logo.jpg">
                                                    </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="widget-stat card">
                                        <div class="card-body p-4">
                                            <a href="#">
                                                    <span class="mr-3 bgl-primary text-primary">
                                                        <!-- <i class="ti-user"></i> -->
                                                        <img src="{{asset('adminpanel/images/marketplace/lazada.jpg')}}"
                                                             alt="lazada.jpg">
                                                    </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="widget-stat card">
                                        <div class="card-body p-4">
                                            <a href="#">
                                                    <span class="mr-3 bgl-primary text-primary">
                                                        <!-- <i class="ti-user"></i> -->
                                                        <img src="{{asset('adminpanel/images/marketplace/shopee.jpg')}}"
                                                             alt="shopee.jpg" width="60px" height="60px">
                                                    </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="widget-stat card">
                                        <div class="card-body p-4">
                                            <a href="#">
                                                    <span class="mr-3 bgl-primary text-primary">
                                                        <!-- <i class="ti-user"></i> -->
                                                        <img src="{{asset('adminpanel/images/marketplace/zalora.png')}}"
                                                             alt="zalora.png">
                                                    </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="widget-stat card">
                                        <div class="card-body p-4">
                                            <a href="#">
                                                    <span class="mr-3 bgl-primary text-primary">
                                                        <!-- <i class="ti-user"></i> -->
                                                        <img src="{{asset('adminpanel/images/marketplace/jd.png')}}"
                                                             alt="jd.png" width="60px" height="60px">
                                                    </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="widget-stat card">
                                        <div class="card-body p-4">
                                            <a href="#">
                                                    <span class="mr-3 bgl-primary text-primary">
                                                        <!-- <i class="ti-user"></i> -->
                                                        <img src="{{asset('adminpanel/images/marketplace/blibli.png')}}"
                                                             alt="blibli.png" width="60px" height="60px">
                                                    </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    @push('dashboard')

    @endpush
@endsection
