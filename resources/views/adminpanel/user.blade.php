@extends('adminpanel.layout.app')
@section('content')
    @push('dashboardcss')
        <link href="{{asset('adminpanel')}}/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
              rel="stylesheet">
    @endpush
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
                        <h4 class="card-title">User Collection</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="userDatatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Name</th>
                                    <th>Journey List</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($dataCoupon->isNotEmpty())
                                    @foreach($dataCoupon as $single)
                                        <tr>
                                            <td>{{$single->id}}</td>
                                            <td>{{$single->name}}</td>
                                            <td>
                                                <a href="{{route('user-journey',$single->id)}}">Journey List</a>
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
    <!--**********************************
        Content body end
    ***********************************-->
    @push('dashboard')
        <script src="{{asset('adminpanel/')}}/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{asset('adminpanel/')}}/dist/js/pages/datatable/datatable-basic.init.js"></script>
        <script>
            (function ($) {
                "use strict";
                $('#userDatatable').DataTable({
                    responsive: true
                });
                $('#userDatatable tbody').on('click', '.editModalClick', function () {
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let phone = $(this).data('phone');
                    let email = $(this).data('email');
                    let address = $(this).data('address');
                    let qualification = $(this).data('qualification');
                    let specialization = $(this).data('specialization');
                    let link = $(this).data('link');
                    $('#editid').val(id);
                    $('#editname').val(name);
                    $('#editphone').val(phone);
                    $('#editemail').val(email);
                    $('#editaddress').val(address);
                    $('#editqualification').val(qualification);
                    $('#editspecialization').val(specialization);
                    $('#editlink').val(link);
                    $('.editModal').modal('show');
                }).on('click', '.deleteModalClick', function () {
                    let id = $(this).data('id');
                    $('#deleteid').val(id);
                    $('.deleteModal').modal('show');
                }).on('click', '.lock', function () {
                    let id = $(this).data('id');
                    $.ajax({
                        type: 'POST',
                        url: "{{route('lockUser')}}",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'id': id,
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                }).on('click', '.unlock', function () {
                    let id = $(this).data('id');
                    $.ajax({
                        type: 'POST',
                        url: "{{route('unlockUser')}}",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'id': id,
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });
            })(jQuery);

        </script>
    @endpush
@endsection
