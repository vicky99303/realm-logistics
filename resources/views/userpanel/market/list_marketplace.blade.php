@extends('userpanel.layout.app')
@section('content')
<!--**********************************
        Content body start
    ***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('sdashboard')}}">App</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Setting</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Marketplace</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Marketplace List</h4>
                        <a href="{{route('new-order')}}" class="btn btn-primary btn-xs float-right">Add</a>
                        <a href="{{route('new-order')}}" class="btn btn-primary btn-xs float-right">List</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Marketplace</th>
                                    <th>Status</th>
                                    <th>Datetime Integration</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
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

<script src="{{asset('adminpanel//vendor/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Counter Up -->
<script src="{{asset('adminpanel/vendor/waypoints/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('adminpanel/vendor/jquery.counterup/jquery.counterup.min.js')}}"></script>

<!-- Apex Chart -->
<script src="{{asset('adminpanel/vendor/apexchart/apexchart.js')}}"></script>

<!-- Chart piety plugin files -->
<script src="{{asset('adminpanel/vendor/peity/jquery.peity.min.js')}}"></script>

<!-- Dashboard 1 -->
<script src="{{asset('adminpanel/js/dashboard/dashboard-1.js')}}"></script>
@endpush
@endsection
