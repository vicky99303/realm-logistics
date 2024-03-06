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
                        <h4 class="card-title">Order List</h4>
                        {{--                    <a href="{{route('new-order')}}" class="btn btn-primary btn-xs float-right">New</a>--}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="display" style="min-width: 845px">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Order_id</th>
                                    <th>Invoice</th>
                                    <th>Name MarketPlace</th>
                                    <th>Customer Name</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Courier</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($orderDetail))
                                    @foreach($orderDetail as $singleProduct)
                                        @for($i=0; $i< 2; $i++)
                                            <tr>
                                                <td>{{$singleProduct->id}}</td>
                                                <td>
                                                    @if(!empty($singleProduct->getCategories))
                                                        <ol>
                                                            @foreach($singleProduct->getCategories as $singleCategory)
                                                                <li>
                                                                    <span>&bull;&nbsp;</span>{{$singleCategory->name}}
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                    @endif
                                                </td>
                                                <td>{{$singleProduct->name}}</td>
                                                <td>{{$singleProduct->price_value}}</td>
                                                <td></td>
                                                <td></td>
                                                <td>{{(!empty($singleProduct->getStock))?$singleProduct->getStock->main_stock:''}}</td>
                                                <td>
                                                    @if(!empty($singleProduct->getImages))
                                                        @foreach($singleProduct->getImages as $singleImage)
                                                            <img class="img-thumbnail"
                                                                 src="{{$singleImage->thumbnail_url}}"
                                                                 alt="productImage"/>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>{{($singleProduct->status == 1)?'Active':'Not Active'}}</td>

                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endfor
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
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
    @push('packagejs')
        <!-- Dashboard 1 -->
        <script src="{{asset('adminpanel/')}}/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{asset('adminpanel/')}}/dist/js/pages/datatable/datatable-basic.init.js"></script>
    @endpush
@endsection
