@extends('userpanel.layout.app')
@section('content')
    <link href="{{asset('adminpanel')}}/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="{{asset('adminpanel/css/style.css')}}" rel="stylesheet">
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
                        <h4 class="card-title">Product List</h4>
                        <div class="btn-group mb-2  btn-group-sm float-right ">
                            <a href="{{route('new-product')}}" class="btn btn-primary btn-xs ">AddProduct</a>
                            <a href="#" class="btn btn-primary btn-xs">Export Product</a>
                            <a href="#" class="btn btn-primary btn-xs">Import Product</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Categories</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Image Product</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($productInfo->isNotEmpty())
                                    @foreach($productInfo as $singleProduct)
                                        <tr>
                                            <td>{{$singleProduct->id}}</td>
                                            <td>
                                                @if($singleProduct->getCategories->isNotEmpty())
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
                                            <td>{{$singleProduct->getStock->main_stock}}</td>
                                            <td>
                                                @if($singleProduct->getImages->isNotEmpty())
                                                    @foreach($singleProduct->getImages as $singleImage)
                                                        <img src="{{$singleImage->thumbnail_url}}"
                                                             alt="productImage"/>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{($singleProduct->status == 1)?'Active':'Not Active'}}</td>
                                            <td>
                                                <button type="button" class="btn btn-rounded btn-info">
                                                        <span class="btn-icon-left text-info">
                                                            <i class="fa fa-plus color-info"></i>
                                                        </span>
                                                </button>
                                            </td>
                                        </tr>
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
    @push('dashboard')
        <script src="{{asset('adminpanel/')}}/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{asset('adminpanel/')}}/dist/js/pages/datatable/datatable-basic.init.js"></script>
    @endpush
@endsection
