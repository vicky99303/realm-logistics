@extends('userpanel.layout.app')
@section('content')
    <link href="{{asset('adminpanel')}}/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
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
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tokopedia List</h4>
                        <a type="button" class="btn btn-primary float-right " href="{{route('addtokopedia')}}">Add
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tokopediaDatatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Client Id</th>
                                    <th>Client Secret</th>
                                    <th>App Id</th>
                                    <th>Base64</th>
                                    <th>Status</th>
                                    <th>Datetime Integration</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($tokenDetail->isNotEmpty())
                                    @foreach($tokenDetail as $single)
                                        <tr>
                                            <td>{{$single->client_id}}</td>
                                            <td>{{$single->client_secret}}</td>
                                            <td>{{$single->app_id}}</td>
                                            <td>{{$single->base64}}</td>
                                            <td>{{$single->status}}</td>
                                            <td>{{$single->created_at}}</td>
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{route('tokopedia-shop',['tokenId'=>$single->id])}}">
                                                    view store managment
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
        <script src="{{asset('adminpanel/js/custom/user/tokopedia.js')}}"></script>
    @endpush
@endsection
