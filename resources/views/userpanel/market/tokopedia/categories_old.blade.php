@extends('userpanel.layout.app')
@section('content')
    <link href="{{asset('adminpanel/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('sdashboard')}}">App</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Setting</a></li>
                        <li class="breadcrumb-item"><a href="{{route('market')}}">Marketplace</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Tokopedia</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Categories List</h4>
                            <a type="button" class="btn btn-primary"
                               href="{{route('tokopedia-categories-refresh',['tokenId'=>$tokenId,'fs_id'=>$fs_id])}}">
                                Refresh Categories Data
                            </a>
                        </div>
                        <div class="card-body">
                            @if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                            @endif
                            <div class="table-responsive">
                                <table id="tokopediaStoreDatatable" class="display" style="min-width: 845px">
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
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
    @push('dashboard')
        <script src="{{asset('adminpanel/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('adminpanel/js/custom/user/store.js')}}"></script>
    @endpush
@endsection
