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
                <li class="breadcrumb-item "><a href="{{route('order')}}">Order List</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">New</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">New Order</h4>
                </div>
                <div class="card-body">
                    <div class="pt-3">
                        <div class="settings-form">
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                    <ul>
                                        <li>{!! \Session::get('success') !!}</li>
                                    </ul>
                                </div>
                            @endif
                            <form >
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Invoice</label>
                                        <input type="text" placeholder="Invoice" class="form-control @error('name') is-invalid @enderror" name="name" value="">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Name_Marketplace</label>
                                        <input type="email" placeholder="Name Marketplace" class="form-control @error('email') is-invalid @enderror" name="email" value="">
                                        @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Customer_name</label>
                                        <input type="password" placeholder="Customer Name" class="form-control @error('password') is-invalid @enderror" name="password">
                                        @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Product_name</label>
                                        <input type="text" placeholder="Product Name" class="form-control @error('address1') is-invalid @enderror" name="address1" value="">
                                        @error('address1')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Quantity</label>
                                        <input type="text" placeholder="Quantity" class="form-control @error('address2') is-invalid @enderror" name="address2" value="">
                                        @error('address2')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Courier</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror " name="city" value="">
                                        @error('city')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Total</label>
                                        <input type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" value="">
                                        @error('zip')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Accept</button>
                                <button class="btn btn-primary" type="submit">Cancel</button>
                            </form>
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
    <script src="{{asset('adminpanel/js/dashboard/dashboard-1.js')}}"></script>
    <script src="{{asset('adminpanel/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('adminpanel/js/plugins-init/datatables.init.js')}}"></script>
@endpush
@endsection
