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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sales Reports</h4>
                    </div>
                    <div class="card-body">
                        @if(isset($productInfo) && $productInfo->isNotEmpty())
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <th>No</th>
                                <th>Product Name</th>
                                <th>Stock</th>
                                <th>stock use status</th>
                                </thead>
                                <tbody>
                                @if(isset($productInfo) && $productInfo->isNotEmpty())
                                    @foreach($productInfo as $singleProduct)
                                        <tr>
                                            <td>{{$singleProduct->id}}</td>
                                            <td>{{$singleProduct->name}}</td>
                                            <td>{{$singleProduct->getStock->main_stock}}</td>
                                            <td>{{($singleProduct->getStock->use_stock == 1)?'use stock':'not use stock'}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        @endif
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
