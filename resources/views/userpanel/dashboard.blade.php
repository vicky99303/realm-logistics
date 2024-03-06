@extends('userpanel.layout.app')
@section('content')
    <link href="{{asset('adminpanel')}}/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
          rel="stylesheet">
    <!--**********************************
            Content body start
        ***********************************-->
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
            <div class="col-xl-4 col-xxl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="widget-stat card">
                    <div class="card-body p-4">
                        <div class="media ai-icon">
                            <div class="media-body">
                                <h3 class="mb-0 text-black"><span class="counter ml-0">Total Amount</span></h3>
                                <p class="mb-0">{{(isset($dataPaymentRecord)&& !empty($dataPaymentRecord)?$dataPaymentRecord:0)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-xxl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="widget-stat card">
                    <div class="card-body p-4">
                        <div class="media ai-icon">
                            <div class="media-body">
                                <h3 class="mb-0 text-black"><span class="counter ml-0">Total Product In Tokopedia</span></h3>
                                <p class="mb-0">{{(isset($productCountTokopediaCount)&& !empty($productCountTokopediaCount)?$productCountTokopediaCount:0)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-xxl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="widget-stat card">
                    <div class="card-body p-4">
                        <div class="media ai-icon">
                            <div class="media-body">
                                <h3 class="mb-0 text-black"><span class="counter ml-0">Number Of Package Buy</span></h3>
                                <p class="mb-0">{{(isset($numberOfPackageBuy)&& !empty($numberOfPackageBuy)?$numberOfPackageBuy:0)}}</p>
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
        <script src="{{asset('adminpanel/')}}/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{asset('adminpanel/')}}/dist/js/pages/datatable/datatable-basic.init.js"></script>
    @endpush
@endsection
