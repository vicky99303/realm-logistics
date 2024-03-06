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
                            <h4 class="card-title">Store List</h4>
                            <a type="button" class="btn btn-primary"
                               href="{{route('tokopedia-shop-refresh',$tokenId)}}">
                                Refresh Store Data
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                @if(Session::has('message'))
                                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                                @endif
                                <table id="tokopediaStoreDatatable" class="display" style="min-width: 845px">
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
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
    @push('dashboard')
        <script src="{{asset('adminpanel/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('adminpanel/js/custom/user/store.js')}}"></script>
    @endpush
@endsection
