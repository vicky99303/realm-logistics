@extends('userpanel.layout.app')
@section('content')
    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('sdashboard')}}">App</a></li>
                        <li class="breadcrumb-item active"><a
                                    href="javascript:void(0)">{{isset($breadCrumb)?$breadCrumb:'Setting'}}</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Marketplace</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
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
    </div>
    <!--**********************************
        Content body end
    ***********************************-->

    @push('dashboard')

        <script src="{{asset('adminpanel//vendor/chart.js/Chart.bundle.min.js')}}"></script>
        <!-- Counter Up -->
        <script src="{{asset('adminpanel/vendor/waypoints/jquery.waypoints.min.js')}}"></script>
        <script src="{{asset('adminpanel/vendor/jquery.counterup/jquery.counterup.min.js')}}"></script>

        <!-- Apex Chart -->
        <script src="{{asset('adminpanel/vendor/apexchart/apexchart.js')}}"></script>

        <!-- Chart piety plugin files -->
        <script src="{{asset('adminpanel/vendor/peity/jquery.peity.min.js')}}"></script>

        <!-- Dashboard 1 -->
        <script src="{{asset('adminpanel/js/dashboard/dashboard-1.js')}}"></script>
    @endpush
@endsection
