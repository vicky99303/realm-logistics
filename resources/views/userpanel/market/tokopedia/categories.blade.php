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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Categories List</h4>
                        <a type="button" class="btn btn-primary float-right""
                           href="{{route('tokopedia-categories-refresh',['tokenId'=>$tokenId,'fs_id'=>$fs_id])}}">
                            Refresh Categories Data
                        </a>
                    </div>
                    <div class="card-body">
                        @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                        @endif
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Category Id</th>
                                    <th>Category Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($categoryDetail->isNotEmpty())
                                    @foreach($categoryDetail as $single)
                                        @if(isset($single['id']))
                                            <tr>
                                                <td>{{$single['id']}}</td>
                                                <td>{{$single['name']}}</td>
                                            </tr>
                                        @endif
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
