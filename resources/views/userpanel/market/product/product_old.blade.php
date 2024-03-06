@extends('userpanel.layout.app')
@section('content')
    <link href="{{asset('adminpanel/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="{{asset('adminpanel/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{asset('adminpanel/css/style.css')}}" rel="stylesheet">
    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('sdashboard')}}">App</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Product List</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product List</h4>
                            <div class="btn-group mb-2  btn-group-sm">
                                <a href="{{route('new-product')}}" class="btn btn-primary btn-xs float-right">Add
                                    Product</a>
                                <a href="#" class="btn btn-primary btn-xs float-right">Export Product</a>
                                <a href="#" class="btn btn-primary btn-xs float-right">Import Product</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display" style="min-width: 845px">
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
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
    @push('dashboard')
        <script src="{{asset('adminpanel/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('adminpanel/js/plugins-init/datatables.init.js')}}"></script>
    @endpush
@endsection
