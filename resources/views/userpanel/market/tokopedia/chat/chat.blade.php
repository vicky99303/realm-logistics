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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Chat</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="email-left-box px-0 mb-3">
                                <div class="intro-title d-flex justify-content-between">
                                    <h5>Categories</h5>
                                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                </div>
                                <div class="mail-list mt-4">
                                    <a href="email-inbox.html" class="list-group-item"><span class="icon-warning"><i
                                                    class="fa fa-circle" aria-hidden="true"></i></span>
                                        User 1 </a>
                                    <a href="email-inbox.html" class="list-group-item"><span class="icon-primary"><i
                                                    class="fa fa-circle" aria-hidden="true"></i></span>
                                        User 2 </a>
                                </div>
                            </div>
                            <div class="email-right-box ml-0 ml-sm-4 ml-sm-0">

                                <div class="compose-content">
                                    <form action="#">
                                        <div class="form-group">
                                            <input type="text" class="form-control bg-transparent" placeholder=" To:">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control bg-transparent" placeholder=" Subject:">
                                        </div>
                                        <div class="form-group">
                                            <textarea id="email-compose-editor" class="textarea_editor form-control bg-transparent" rows="15" placeholder="Enter text ..."></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="text-left mt-4 mb-5">
                                    <button class="btn btn-primary btn-sl-sm mr-2" type="button"><span class="mr-2"><i class="fa fa-paper-plane"></i></span>Send</button>
                                    <button class="btn btn-danger light btn-sl-sm" type="button"><span class="mr-2"><i class="fa fa-times" aria-hidden="true"></i></span>Discard</button>
                                </div>
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
