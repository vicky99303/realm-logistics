@extends('userpanel.layout.app')
@section('content')
    @push('packagecss')
        <link href="{{asset('adminpanel')}}/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
              rel="stylesheet">
        <!-- Datatable -->
        <style>
            .loader {
                border: 16px solid #f3f3f3; /* Light grey */
                border-top: 16px solid #3498db; /* Blue */
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 2s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
    @endpush
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://js.xendit.co/v1/xendit.min.js"></script>
    <script>
        $(function () {
            $('#package_id').change(function () {
                var amount = $(this).find(':selected').attr('data-amount');
                $('#amount').val(amount);
            });
        });
    </script>
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
                        <h4 class="card-title">Buy Collection</h4>
                        <button type="button" class="btn btn-rounded btn-primary float-right " data-toggle="modal"
                                data-target=".addModal">Buy
                        </button>
                    </div>
                    <div class="card-body">
                        <div>
                            Current Amount = {{(isset($dataDeposit->current_amount))?$dataDeposit->current_amount:0}}
                            <br/>
                            Used Amount = {{(isset($dataDeposit->used_amount))?$dataDeposit->used_amount:0}} <br/>
                        </div>
                        @if($errors->any())
                            <div class="alert alert-danger">{{$errors->first()}}</div>
                        @elseif(session()->has('message'))
                            <div class="alert alert-success">{{ session()->get('message') }}</div>
                        @endif
                        <div class="table-responsive">
                            @if($dataCoupon->isNotEmpty())
                                <table id="buyPackageDatatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>S. No</th>
                                        <th>package_id</th>
                                        <th>price</th>
                                        <th>created_at</th>
                                        {{--                                        <th>Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($dataCoupon as $single)
                                        <tr>
                                            <td>{{$single->id}}</td>
                                            <td>{{$single->package_id}}</td>
                                            <td>{{$single->price}}</td>
                                            <td>{{$single->created_at}}</td>
                                            {{--                                                <td>--}}
                                            {{--                                                    <div class="d-flex">--}}
                                            {{--                                                        <button class="btn btn-primary shadow btn-xs sharp mr-1 editModalClick"><i class="fa fa-pencil"></i></button>--}}
                                            {{--                                                        <button class="btn btn-danger shadow btn-xs sharp deleteModalClick"><i class="fa fa-trash"></i></button>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                </td>--}}
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            @endif
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
    {{--  Add Modal  --}}
    <div class="modal fade addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buy Package</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('getStorePackagePaymentAmount')}}">
                        @csrf
                        <div id="error" style="display:none;">
                            <div class=" alert alert-danger alert-dismissible fade show request">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <polygon
                                            points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                                <strong>Error!</strong> <span class="result"></span>
                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
                                    <span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                        </div>
                        <div id="success" style="display:none;">
                            <div class="alert alert-success alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                <strong>Success!</strong><span class="result"></span>
                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
                                    <span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                        </div>
                        <input class="form-control" type="hidden" id="deposit_id" name="deposit_id"
                               value="{{(isset($dataDeposit->id) && !empty($dataDeposit))?$dataDeposit->id:''}}"/>
                        <div class="form-row credit-card-box">
                            <div class="form-group col-md-6">
                                <label>Package</label>
                                <select id="package_id" name="package_id" class="form-control">
                                    <option selected>Choose...</option>
                                    @if($dataPackage->isNotEmpty())
                                        @foreach($dataPackage as $single)
                                            <option value="{{$single->id}}"
                                                    data-amount="{{$single->price}}">{{$single->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>AMOUNT</label>
                                <input class="form-control" type="text" id="amount" name="amount" placeholder="Amount"
                                       value="75000"
                                       required readonly/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Currently Available Amount</label>
                                <input class="form-control" type="text" id="deposit_amount" name="deposit_amount"
                                       value="{{(isset($dataDeposit->current_amount))?$dataDeposit->current_amount:''}}"
                                       readonly/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Year</label>
                                <select id="deposit_id" name="deposit_id" class="form-control">
                                    <option selected>Choose...</option>
                                    <option value="1">1 Year</option>
                                    <option value="3">3 Years</option>
                                    <option value="6">6 Years</option>
                                </select>
                            </div>
                        </div>
                        <button class="submit subscribe btn btn-success btn-lg btn-block" type="submit">Pay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('packagejs')
        <!-- Dashboard 1 -->
        <script src="{{asset('adminpanel/js/deznav-init.js')}}"></script>
        <!-- Datatable -->
        <script src="{{asset('adminpanel/')}}/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{asset('adminpanel/')}}/dist/js/pages/datatable/datatable-basic.init.js"></script>
        <script src="{{asset('adminpanel/js/custom/user/package.js')}}"></script>
    @endpush
@endsection
