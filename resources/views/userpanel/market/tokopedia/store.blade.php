@extends('userpanel.layout.app')
@section('content')
    <link href="{{asset('adminpanel')}}/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="{{asset('adminpanel/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
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
                        <h4 class="card-title">Store List</h4>
                        <a type="button" class="btn btn-primary  float-right"
                           href="{{route('tokopedia-shop-refresh',$tokenId)}}">
                            Refresh Store Data
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                            @endif
                            <table id="tokopediaStoreDatatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>shop_name</th>
                                    <th>logo</th>
                                    <th>status</th>
                                    <th>Datetime Integration</th>
                                    <th>Update Datetime</th>
                                    <th>Categories</th>
                                    <th>Product</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($storeDetail->isNotEmpty())
                                    @foreach($storeDetail as $single)
                                        <tr>
                                            <td>{{$single->shop_name}}</td>
                                            <td>
                                                @if(isset($single->logo))
                                                    <img src="{{$single->logo}}" alt="shop-logo" width="50"
                                                         height="50">
                                                @endif
                                            </td>
                                            <td>{{$single->status}}</td>
                                            <td>{{$single->created_at}}</td>
                                            <td>{{$single->updated_at}}</td>
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{route('tokopedia-categories',['tokenId'=>$tokenId,'fs_id'=>$single->fs_id])}}">
                                                    view
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{route('tokopedia-product',['tokenId'=>$tokenId,'fs_id'=>$single->fs_id,'shop_id'=>$single->shop_id])}}">
                                                    view
                                                </a>
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
        <script src="{{asset('adminpanel/js/custom/user/store.js')}}"></script>
    @endpush
@endsection
